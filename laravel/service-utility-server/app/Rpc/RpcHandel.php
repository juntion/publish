<?php

namespace App\Rpc;

use App\Events\LogoutEvent;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Rpc\Service\AuthService;
use App\Rpc\Service\ErpService;
use App\Rpc\Service\PM\BugService;
use App\Rpc\Service\PM\ProductService;
use App\Rpc\Traits\RpcTrait;
use Hprose\Http\Server;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RpcHandel
{
    use RpcTrait;

    // 子系统调用来源
    protected static $from;

    protected $services = [
        'Erp' => ErpService::class,
        'Bug' => BugService::class,
        'Product' => ProductService::class,
        'Auth' => AuthService::class,
    ];

    /**
     * 启动Rpc服务
     */
    public function start()
    {
        $service = new Server();
        $service->addMethod('logout', $this);
        $service->addMethod('getTokenByTicket', $this);
        $service->addMethod('getTokenByOriginId', $this);
        $service->addMethod('permissionCheck', $this);
        $service->addMethod('getUserByToken', $this);
        foreach ($this->services as $serviceName => $class) {
            $service->addInstanceMethods(new $class(), $class, $serviceName);
        }

        // 权限认证
        $service->addInvokeHandler([self::class, 'authentication']);
        $service->start();
    }

    /**
     * Rpc调用简单认证
     * @param $name
     * @param array $args
     * @param \stdClass $context
     * @param \Closure $next
     * @return array
     */
    public static function authentication($name, array &$args, \stdClass $context, \Closure $next)
    {
        $except = ['Erp_appLogin'];
        $username = $_SERVER['HTTP_USERNAME'];
        $password = $_SERVER['HTTP_PASSWORD'];
        self::$from = $_SERVER['HTTP_GUARDNAME'];

        $logData = ['name' => $name, 'args' => $args];
        if ($username == config('app.rpc.username') && $password == config('app.rpc.password')) {
            $debug = !empty($_SERVER['HTTP_DEBUG_DATA']) ? @json_decode($_SERVER['HTTP_DEBUG_DATA']) : [];
            if (!in_array($name, $except)) logger()->channel('rpc')->debug(json_encode($logData), $debug ?: []);
            return self::success($next($name, $args, $context));
        }
        logger()->channel('rpc')->error(json_encode(array_merge($logData, ['error' => 'Unauthenticated'])));
        return self::failed('Unauthenticated.', 401);
    }

    /**
     * 触发注销事件，注销所有登录
     * @param $userId
     * @param $token
     * @return array
     */
    public function logout($userId, $token)
    {
        event(new LogoutEvent($userId, self::$from, $token));
        return self::success();
    }

    /**
     * 权限检查
     * @param $userId
     * @param $permission
     * @return array
     */
    public function permissionCheck($userId, $permission)
    {
        $model = $this->getModel($userId);
        if ($model->can($permission)) {
            return self::success();
        }
        return self::failed('Unauthorized');
    }

    /**
     * 获取子系统模型
     * @param $userId
     * @return mixed
     */
    public function getModel($userId)
    {
        $user = User::find($userId);
        $user->guard_name = self::$from;
        return $user;
    }

    /**
     * 使用票据获取令牌
     * @param $ticket
     * @return array
     * @author: King
     * @version: 2020/6/24 17:26
     */
    public function getTokenByTicket($ticket)
    {
        $token = Cache::tags('user_tickets')->get($ticket);
        Cache::tags('user_tickets')->forget($ticket);
        return self::success($token);
    }

    /**
     * 获取用户访问令牌
     * @param $originId
     * @return array
     * @author: King
     * @version: 2020/6/30 16:33
     */
    public function getTokenByOriginId($originId)
    {
        $user = User::query()->where('origin_id', $originId)->first();
        if ($user) {
            $token = Auth::guard()->fromUser($user);
            return self::success($token);
        } else {
            return self::failed('User not found');
        }
    }

    /**
     * 获取用户信息
     * @param $token
     * @param $guardName
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getUserByToken($token, $guardName)
    {
        Auth::guard()->setToken($token);
        if (!Auth::guard()->check()) {
            return self::success(false);
        }
        $user = Auth::guard()->user();
        $userData = app()->make(UserRepository::class)->userData($user, $guardName);

        return self::success($userData);
    }
}
