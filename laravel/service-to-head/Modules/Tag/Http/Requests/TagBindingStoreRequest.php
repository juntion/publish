<?php

namespace Modules\Tag\Http\Requests;

class TagBindingStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'tag_uuid' => 'required|exists:tag_data,uuid',
            'binding_type' => 'required',
            'model_id' => 'required',
            'model_desc' => 'required|string',
            'priority' => 'integer',
        ];
    }

    public function attributes()
    {
        return [
            'tag_uuid' => '标签',
            'binding_type' => '所属绑定',
            'model_id' => '数据源唯一ID',
            'model_desc' => '数据源名称或描述',
            'priority' => '排序',
        ];
    }
}
