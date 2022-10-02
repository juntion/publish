<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncAdminRolesPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'roles' => 'present|array',
            'defaultRole' => 'present',
            'permissions' => 'present|array'
        ];
    }
}
