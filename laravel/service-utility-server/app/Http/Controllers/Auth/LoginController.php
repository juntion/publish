<?php

namespace App\Http\Controllers\Auth;

use App\Events\LogoutEvent;
use App\Events\Mail\LoginValidateCodeEvent;
use App\Http\Controllers\Controller;
use App\Models\LoginTrack;
use App\Models\SubsystemRpcInfo;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class LoginController extends Controller
{
    use ThrottlesLogins;

    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function login(Request $request)
    {
        // 验证登录信息
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $clientGroup = $request->input('client_group');
        $guardName = $request->input('guard_name');
        // 登录成功将token和用户信息返给前端，前端保存token
        // 如果存在redirect_url，由前端携带token去跳转页面
        // 不存在redirect_url，直接进入sso后台
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            // 需要验证码验证
            if (!$this->isCommunal($user) && $code = $this->loginValidateCodeCache()->get($user->id)) {
                $requestCode = $request->input('code');
                if (!$requestCode || $requestCode != $code) {
                    return $this->failedWithMessage(__('auth.code'), FoundationResponse::HTTP_LOCKED);
                }
                // 使code过期
                $this->loginValidateCodeCache()->forget($user->id);
            } else {
                if ($this->checkLoginNeedValidate($user, $request->input('client_token', ''))) {
                    return $this->failedWithMessageAndErrors(
                        ['email' => $user->receiveCodeEmail],
                        __('auth.need_validate', ['email' => $user->receiveCodeEmail]),
                        FoundationResponse::HTTP_LOCKED);
                }
            }

            $this->loginTrack($user->id, $guardName);

            if ($this->needChangePassword($user->update_pass_time)) {
                return $this->failedWithMessage(__('auth.update_pass'));
            }

            if ($this->checkForbid($user, $guardName)) {
                return $this->failedWithMessage(__('auth.forbid'));
            }

            return $this->sendLoginResponse($user, $guardName, $clientGroup);
        }
        // 登录失败
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        // 同步注销
        event(new LogoutEvent($this->user()->id, config('app.guard'), Auth::getToken()->get()));
        $this->guard()->logout();
        return $this->success();
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'guard_name' => 'required|string',
        ]);
    }

    public function username()
    {
        // 前端传过来的键名
        return 'username';
    }

    // 验证用户名密码
    protected function attemptLogin(Request $request)
    {
        $account = $request->get($this->username());
        $password = $request->get('password');
        return $this->guard()->attempt(['name' => $account, 'password' => $password]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    protected function sendLoginResponse(User $user, $guardName, $clientGroup)
    {
        $token = $this->guard()->getToken()->get();
        $expiration = $this->guard()->getPayload()->get('exp');
        $ticket = $this->user->makeTicket();
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiration,
            'ticket' => $ticket,
            'name' => $user->name,
            'stats_token' => $this->makeStatsToken(),
        ];

        $this->user->saveToken($user, $token, $expiration);

        // 设备码
        $clientToken = Str::random(20);
        $cookieExpires = 60 * 60 * 24 * 7; // 7天
        $this->clientTokenCache()->put($user->id, $clientToken, $cookieExpires);
        $data['client_token'] = $clientToken;

        // 通知其他系统重新登录
        if ($clientGroup) {
            // 通知各系统重新登录
            foreach (SubsystemRpcInfo::getRpcClients() as $rpcClient) {
                $rpcClient->reLogin($clientGroup);
            }
        }

        return $this->successWithData($data);
    }

    /**
     * 设备码缓存
     * @return mixed
     */
    protected function clientTokenCache()
    {
        return Cache::tags('user_client_tokens');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return $this->failedWithMessage(__('auth.failed'));
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return $this->failedWithMessage(__('auth.throttle', ['seconds' => $seconds]));
    }

    // 系统禁用检查
    protected function checkForbid($user, $guardName)
    {
        return $user->forbidSubsystems()->where('guard_name', $guardName)->first();
    }

    // 登录日志记录
    protected function loginTrack($userId, $guardName)
    {
        $ip = getIP();
        $data = [
            'user_id' => $userId,
            'guard_name' => $guardName,
            'ip_address' => $ip,
            'city' => getCityFromIp($ip),
            'browser' => getBrowser()['browser'],
        ];
        LoginTrack::create($data);
    }

    /**
     * 需要验证
     * @param User $user
     * @param $clientToken
     * @return bool
     */
    protected function checkLoginNeedValidate(User $user, $clientToken)
    {
        // 测试环境、公共账号不需要验证
        if (isTesting() || $this->isCommunal($user)) {
            return false;
        }
        $lastLogin = $user->loginHistory()->first();
        if ($lastLogin) {
            // 设备码正确 无需邮件验证
            if ($clientToken && $clientToken == $this->clientTokenCache()->get($user->id)) {
                return false;
            }
            if (getIP() != $lastLogin->ip_address || getBrowser()['browser'] != $lastLogin->browser) {
                $this->sendValidateCodeEmail($user);
                return true;
            }
        }
        return false;
    }

    /**
     * 是否不需要验证码（公共账号）
     * @param User $user
     * @return bool
     * @author: King
     * @version: 2020/7/2 16:46
     */
    protected function isCommunal(User $user)
    {
        return $user->is_communal > 0;
    }

    /**
     * 发送验证码邮件
     * @param $user
     */
    protected function sendValidateCodeEmail($user)
    {
        $code = random_int(1000, 9999);
        $this->loginValidateCodeCache()->put($user->id, $code, 10 * 60);
        try {
            event(new LoginValidateCodeEvent($user, $code));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * 验证码缓存
     * @return mixed
     */
    protected function loginValidateCodeCache()
    {
        return Cache::tags('user_login_validate_code');
    }

    /**
     * 是否需要更新密码，每90天需要更新一次密码
     * @param $updatePasswordTime
     * @return bool
     */
    protected function needChangePassword($updatePasswordTime)
    {
        if (isTesting()) {
            return false;
        }
        return time() - strtotime($updatePasswordTime) > 3600 * 24 * 90;
    }

    /**
     * 刷新token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function refreshToken(Request $request, $id)
    {
        try {
            $oldToken = Auth::getToken()->get();
            $token = auth()->refresh();
            auth()->setToken($token);
            $user = auth()->user();
            $expiration = time() + auth()->factory()->getTTL() * 60;
            $userData = $this->user->userData($user, config('app.guard'));
            $ticket = $this->user->makeTicket();
            $result = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiration,
                'ticket' => $ticket,
                'stats_token' => $this->makeStatsToken(),
            ];
            $result = array_merge($result, $userData);
            $this->user->saveToken($user, $token, $expiration);
            // 通知各系统刷新token
            foreach (SubsystemRpcInfo::getRpcClients() as $rpcClient) {
                $rpcClient->refreshToken(md5($oldToken), $token);
            }
            return $this->successWithData($result);
        } catch (\Exception $e) {
            // 在黑名单里面的token是不能刷新的
            return $this->failedWithMessage(__('auth.expired'), FoundationResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * 发送验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCodeEmail(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|exists:users,name',
        ]);

        if ($this->limiter()->attempts($this->emailThrottleKey($request)) > 0) {
            return $this->failedWithMessage(__('auth.email_throttle'), Response::HTTP_TOO_MANY_REQUESTS);
        }

        $user = User::query()->where('name', $request->input($this->username()))->first();
        $this->sendValidateCodeEmail($user);
        $this->limiter()->hit($this->emailThrottleKey($request));

        return $this->successWithData(['email' => $user->receiveCodeEmail]);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function emailThrottleKey(Request $request)
    {
        return 'validateCodeEmail|' . Str::lower($request->input($this->username())) . '|' . $request->ip();
    }

    /**
     * 生成数据统计接口token
     * @return string
     */
    protected function makeStatsToken()
    {
        $token = config('app.stats_api_token');
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@-';
        $betaTimeRand = time() . '.' . rand(1,999);
        $randStr = $str[rand(0,63)] . $str[rand(0,63)] . $str[rand(0,63)] . $str[rand(0,63)];
        $sign = md5($token . $betaTimeRand . $randStr) .
            ':' . $randStr . ':' . md5(\request()->server('SERVER_NAME') . $randStr);
        return $sign . ':' . $betaTimeRand;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByTicket(Request $request)
    {
        $ticket = $request->get('ticket');
        $token = Cache::tags('user_tickets')->get($ticket);
        if (!$ticket || !$token) {
            return $this->failedWithMessage('票据无效');
        }
        Cache::tags('user_tickets')->forget($ticket);
        Auth::guard()->setToken($token);
        if (!Auth::guard()->check()) {
            return $this->failedWithMessage('登录失效');
        }
        $user = Auth::guard()->user();
        $user->append(['basic_department']);
        return $this->successWithData($user);
    }
}
