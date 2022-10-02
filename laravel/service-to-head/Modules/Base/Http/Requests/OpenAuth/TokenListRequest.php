<?php

namespace Modules\Base\Http\Requests\OpenAuth;

use Modules\Base\Http\Requests\ListRequest;

class TokenListRequest extends ListRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'keyword' => 'sometimes|string',
                'sort.created_at' => 'sometimes|in:asc,desc',
                'sort.updated_at' => 'sometimes|in:asc,desc'
            ]
        );
    }
    
    public function allowFilter(): array
    {
        return [];
    }
    
    public function allowSort(): array
    {
        return ['created_at', 'updated_at'];
    }
}