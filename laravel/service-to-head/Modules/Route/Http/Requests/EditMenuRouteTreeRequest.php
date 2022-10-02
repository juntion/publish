<?php

namespace Modules\Route\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMenuRouteTreeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'form_parent_uuid' => 'present|required_if:node_type,route',
            'to_parent_uuid' => 'present|required_if:node_type,route',
            'node_uuid' => 'required|regex:/^[0-9a-f]{32}$/',// 格式为 aaa     aaa.bbb    aaa.bbb.ccc
            'node_type' => 'required|in:menu,route',
            'sort' => 'required|array',
            'sort.*.parent_uuid' => 'present|required_if:sort.*.node_type,route',
            'sort.*.uuid' => 'required|regex:/^[0-9a-f]{32}$/',
            'sort.*.node_type' => 'required|in:menu,route',
            'sort.*.sort' => 'required|integer|between:0,255',
        ];
    }
}
