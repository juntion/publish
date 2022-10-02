<?php

namespace Modules\Admin\Http\Controllers\Settings;

use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Notifications\UpdateAdmin as UpdateAdminNotification;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Settings\AccountUpdateRequest;
use Modules\Admin\Http\Resources\AdminResource;

class AccountController extends Controller
{
    public function update(AccountUpdateRequest $request, AdminRepository $adminRepository)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $admin = $request->user();

        $originalName = $admin->name;
        $originalEmail = $admin->email;
        $admin->name = $name;
        $admin->email = $email;

        if ($isNotify = $admin->isDirty()) {
            if ($originalName != $name) {
                $request->validate(['name' => 'unique:admins']);
            }
            if ($originalEmail != $email) {
                $request->validate(['email' => 'unique:admins']);
            }
        }

        if ($adminRepository->updateAdmin($admin) && $isNotify) {
            $admin->notify(new UpdateAdminNotification($originalName, $originalEmail));
        }

        return new AdminResource($admin);
    }
}
