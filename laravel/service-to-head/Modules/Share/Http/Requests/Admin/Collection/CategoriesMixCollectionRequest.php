<?php

namespace Modules\Share\Http\Requests\Admin\Collection;


use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class CategoriesMixCollectionRequest extends ListRequest
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
            'filter'      => 'array',
            'filter.type' => 'required|in:video,picture',
            'parent_uuid' => 'sometimes|exists:Modules\Share\Entities\CollectionCategory,uuid'
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
