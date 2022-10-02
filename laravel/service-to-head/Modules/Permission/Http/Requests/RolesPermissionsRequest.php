<?php

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter' => 'required|array',
            'filter.guard_name' => 'required|in:admin,customer,supplier'
        ];
    }
}
