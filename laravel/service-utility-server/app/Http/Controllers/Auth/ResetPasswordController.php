<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\PasswordUpdate;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * 用户名重置密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetByName(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'username' => 'required|exists:users,name',
            'password' => 'required|confirmed|min:8',
        ], $this->validationErrorMessages());

        $user = User::query()->where('name', $request->input('username'))->whereNull('deleted_at')->first();
        $password = $request->input('password');

        if ($msg = $this->user->validatePassword($user, $password)) {
            return $this->failedWithMessage($msg);
        }

        $token = DB::table(config('auth.passwords.users.table'))->where('email', $user->email);
        if (!$token->first() || !Hash::check($request->input('token'), $token->first()->token)) {
            return $this->failedWithMessage(__('passwords.token'));
        }
        $token->delete();
        $this->resetPassword($user, $password);
        // 修改密码更新时间
        $user->update_pass_time = now();
        $user->save();

        // 同步修改密码
        event(new PasswordUpdate($user, $password));

        return $this->successWithMessage(__('passwords.reset'));
    }


    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return $this->successWithMessage(__($response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->failedWithMessage(__($response));
    }

    protected function validationErrorMessages()
    {
        return [
            'password.confirmed' => __('passwords.password'),
            'password.min' => __('passwords.password'),
        ];
    }
}
