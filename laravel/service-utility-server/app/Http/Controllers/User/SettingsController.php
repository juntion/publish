<?php

namespace App\Http\Controllers\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\Auth\PasswordUpdate;
use App\Events\User\UserAssistantLevel;
use App\Events\User\UserUpdate;
use App\Events\User\UserUploadAvatar;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->only('name', 'email', 'admin_telephone');
        $user = $this->user();
        Validator::make($data, [
            'name' => [
                'required', 'max:255', 'regex:/^[a-zA-Z0-9_\-\.]+$/',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => 'required|email|max:255',
            'admin_telephone' => 'max:25',
        ])->validate();
        $user->update($data);
        event(new UserUpdate($user, $data));
        return $this->success();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        Validator::make($request->all(), [
            'password_old' => 'required',
            'password' => 'required|min:8|confirmed'
        ])->validate();

        $password = $request->input('password');
        $user = $this->user();
        if (Hash::check($request->input('password_old'), $user->getAuthPassword())) {
            // 验证新密码格式
            if ($msg = $this->user->validatePassword($user, $password)) {
                return $this->failedWithMessage($msg);
            }

            $user->update([
                'password' => Hash::make($password),
                'update_pass_time' => now(),
            ]);

            // 同步修改密码
            event(new PasswordUpdate($user, $password));

            return $this->success();
        }
        return $this->failedWithMessage(__('error.update.failed'));
    }

    public function setAvatar(Request $request)
    {
        Validator::make($request->all(), [
            'avatar' => 'required|image',
        ])->validate();

        $avatar = $request->file('avatar');
        $path = Upload::addFile($avatar)->save();

        $media = $this->user()->moveTmpMedia($this->user()->getUserAvatarMedia(), $path, true);

        $avatarUrl = $media->getUrl();
        $avatarData = [
            'file_name' => $path->originName,
            'content' => $avatarUrl,
            'ext' => $path->extension,
        ];
        event(new UserUploadAvatar($this->user(), $avatarData));

        return $this->successWithData(['avatar' => $avatarUrl]);
    }

    /**
     * 修改验证码邮箱
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function codeEmail(Request $request)
    {
        Validator::make($request->all(), [
            'code_email' => 'required|email|regex:/@feisu.com$/'
        ])->validate();

        $this->user()->update([
            'code_email' => $request->input('code_email'),
        ]);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param UserRpcInterface $userRpc
     * @return \Illuminate\Http\JsonResponse
     */
    public function assistantLevel(Request $request, UserRpcInterface $userRpc)
    {
        Validator::make($request->all(), [
            'types' => 'required|array',
            'types.*' => 'required|integer',
        ])->validate();

        $result = $userRpc->assistantLevel($request->input('types'));
        if ($result['status'] == 'success') {
            return $this->successWithData($result['data']);
        }
        return $this->failed();
    }

    /**
     * 设置销售职称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAssistantLevel(Request $request)
    {
        Validator::make($request->all(), [
            'assistant_id' => 'required|integer',
            'assistant_name' => 'required|string',
        ])->validate();

        $assistantId = $request->input('assistant_id');
        $user = $this->user();
        $user->update([
            'assistant_id' => $request->input('assistant_id'),
            'assistant_name' => $request->input('assistant_name'),
        ]);
        event(new UserAssistantLevel($user, $assistantId));

        return $this->success();
    }
}
