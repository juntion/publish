<?php

namespace Modules\Share\Http\Requests\Categories;

use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class ResourceTagsRequest extends ListRequest
{
    use PrepareForValidationTrait;

    protected $notMustData = ['tag_uuid', 'is_deep', 'key'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag_uuid'   => 'array',
            'tag_uuid.*' => 'exists:Modules\Share\Entities\ResourceTag,uuid',
            'is_deep'    => 'in:0,1'
        ];
    }

    public function allowFilter(): array
    {
        return [];
    }

    public function allowSort(): array
    {
        return [];
    }
}
