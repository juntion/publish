<?php

namespace App\Http\Controllers;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Repositories\BaseRepository;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ResponseTrait;

    public function __construct()
    {
        $currentRouteName = Route::currentRouteName();
        $suffix = collect(explode('.', $currentRouteName))->last();
        if ($suffix != 'public') {
            $this->middleware('permission:' . $currentRouteName);
        }
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function user()
    {
        return Auth::user();
    }

    protected function getInstance(BaseRepository $repository, $id, $message = 'Bad Request', $code = 400)
    {
        if ($instance = $repository->find((int)$id)) {
            return $instance;
        }

        throw new InvalidParameterException();
    }

    protected function checkPolicy($model, string $policyName)
    {
        if (!$this->user()->can($policyName, $model)) {
            throw new InvalidStatusException('没有权限或该状态下不允许该操作！');
        }
    }
}
