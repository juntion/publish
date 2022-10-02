<?php

namespace Modules\Share\Http\Requests\Resource;

use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class TagsCollectionRequest extends ListRequest
{

    use PrepareForValidationTrait;

    protected $notMustData = ['category_uuid'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter'        => 'array',
            'filter.type'   => 'required|in:video,picture',
            'key'           => 'required',
            'category_uuid' => 'exists:Modules\Share\Entities\ResourceCategory,uuid',
            'tag_uuid'      => 'array',
            'tag_uuid.*'    => 'exists:Modules\Share\Entities\ResourceTag,uuid',
        ];
    }

    public function allowFilter(): array
    {
        return ['type'];
    }

    public function allowSort(): array
    {
        return [];
    }
}
