<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Auth\ResetPasswordRequest;
use Modules\Admin\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->successWithMessage(__($response))
            : $this->failedWithMessage(__($response));
    }

    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    protected function broker()
    {
        return Password::broker('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->save();

        $user->incrementJWTVersion();

        broadcast(new PasswordReset($user))->toOthers();

//        event(new PasswordReset($user));

//        $this->guard()->login($user);
    }
}
