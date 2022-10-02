<?php

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $locales = config('app.locales');
        $localeRule = [];
        foreach ($locales as $k => $v) {
            $localeRule['locale.' . $k] = 'required';
        }

        return array_merge([
            'locale' => 'required|array',
            'name' => 'bail|required|max:255|regex:/^[a-z]+(\.[a-z]+)*$/|not_regex:/^[0-9a-f]{32}$/',// 格式为 aaa     aaa.bbb    aaa.bbb.ccc
            'comment' => 'max:255',
        ], $localeRule);
    }
}
