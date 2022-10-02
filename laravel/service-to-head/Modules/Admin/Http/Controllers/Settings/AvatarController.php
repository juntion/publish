<?php

namespace Modules\Admin\Http\Controllers\Settings;

use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Settings\AvatarUploadRequest;

class AvatarController extends Controller
{
    public function upload(AvatarUploadRequest $request, AdminRepository $adminRepository)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

            $admin = $request->user();
            $avatar = $request->file('avatar');
            $avatarPath = 'avatar' . '/' . substr($admin->uuid, 0, 2);
            $avatarName = $admin->uuid . '.' . $avatar->extension();
            $store = $avatar->storeAs($avatarPath, $avatarName, 'public');

            $admin->avatar = $store;
            $adminRepository->updateAdmin($admin);

            return $this->successWithDataAndMessage(['path' => $admin->avatar]);
        }
        return $this->failedWithMessage(__('admin::settings.uploadFailure'));
    }
}
