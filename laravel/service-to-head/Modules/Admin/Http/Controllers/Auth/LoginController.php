<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Auth\LoginRequest;
use Modules\Admin\Http\Resources\AdminResource;

class LoginController extends Controller
{
//    @todo  laravel 框架升级，导致频率限制不可以，暂时放一下，有时间在改
//    use ThrottlesLogins;

    public $maxAttempts = 3;
    public $decayMinutes = 1440;

    public function login(LoginRequest $request)
    {
//        if ($this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//            return $this->sendLockoutResponse($request);
//        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse();
        }

//        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
    }

    public function username()
    {
        return 'username';
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    protected function attemptLogin(LoginRequest $request)
    {
        return collect(['name', 'email'])->contains(function ($value) use ($request) {
            $account = $request->get($this->username());
            $password = $request->get('password');
            $remember = $request->get('remember', false);

            $isValidation = false;
            if ($value == 'email' && strpos($account, '@') !== false) {
                $isValidation = true;
            }
            if ($value == 'name' && strpos($account, '@') === false) {
                $isValidation = true;
            }
            if (!$isValidation) {
                return false;
            }

            if ($remember) {
                $this->guard()->setTTL(config('admin.remember_ttl'));
            }

            return $this->guard()->attempt([$value => $account, 'password' => $password]);
        });
    }

    protected function sendLockoutResponse(LoginRequest $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return $this->failedWithMessage(__('admin::auth.throttle', ['seconds' => $seconds]));
    }

    protected function sendFailedLoginResponse()
    {
        return $this->failedWithMessage(__('admin::auth.failed'));
    }

    protected function sendLoginResponse()
    {
        $token = $this->guard()->getToken()->get();
        $expiration = $this->guard()->getPayload()->get('exp');
        $admin = $this->guard()->user();

        $data = [
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => $expiration,
            'admin' => $admin,
        ];

        return $this->successWithData($data);
    }

    public function fetchUser()
    {
        $admin = $this->guard()->user();

        return new AdminResource($admin);
    }

    public function logout()
    {
        $this->guard()->logout();
        return $this->success();
    }
}
