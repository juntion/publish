<?php

namespace Modules\Tag\Http\Requests;

class TagStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'status' => 'required|in:1,2',
            'locale' => 'array',
            'locale.*' => 'string',
            'type' => 'required|integer',
            'url_name' => 'sometimes|string',
            'avatar' => 'image',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '标签名称',
            'status' => '标签状态',
            'locale' => '多语言',
            'locale.*' => '多语言',
            'type' => '标签类型',
            'url_name' => 'URL名称',
            'avatar' => '标签头像',
        ];
    }
}
