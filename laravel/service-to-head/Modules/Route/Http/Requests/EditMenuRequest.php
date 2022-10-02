<?php

namespace Modules\Route\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMenuRequest extends FormRequest
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
            'name' => 'bail|required|max:255|regex:/^[a-z]+(\.[a-z]+)*$/',// 格式为 aaa     aaa.bbb    aaa.bbb.ccc
            'icon' => 'present',
            'comment' => 'max:255',
            'locale' => 'required|array',
        ], $localeRule);
    }
}
