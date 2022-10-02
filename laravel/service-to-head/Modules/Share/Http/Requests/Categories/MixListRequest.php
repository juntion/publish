<?php

namespace Modules\Share\Http\Requests\Categories;

use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class MixListRequest extends ListRequest
{
    use PrepareForValidationTrait;
    protected $notMustData = ['parent_uuid', 'key'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_uuid' => 'exists:Modules\Share\Entities\ResourceCategory,uuid',
            'tag_uuid'    => 'array',
            'tag_uuid.*'  => 'exists:Modules\Share\Entities\ResourceTag,uuid',
        ];
    }

    public function allowSort(): array
    {
        return [];
    }

    public function allowFilter(): array
    {
        return [];
    }
}
