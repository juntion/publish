<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncAdminRolesRequest extends FormRequest
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
//            'defaultRole' => 'present|regex:/^[0-9a-f]{32}$/',
        ];
    }
}
