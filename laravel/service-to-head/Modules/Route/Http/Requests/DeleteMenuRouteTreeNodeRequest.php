<?php

namespace Modules\Route\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMenuRouteTreeNodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_uuid' => 'present|required_if:node_type,route',
            'node_type' => 'required|in:menu,route',
            'sort' => 'present|array',
            'sort.*.parent_uuid' => 'present|required_if:sort.*.node_type,route',
            'sort.*.uuid' => 'required|regex:/^[0-9a-f]{32}$/',
            'sort.*.node_type' => 'required|in:menu,route',
            'sort.*.sort' => 'required|integer|between:0,255',
        ];
    }
}
