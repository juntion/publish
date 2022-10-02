<?php

namespace Modules\Share\Http\Requests\Admin;

use Modules\Base\Http\Requests\ListRequest;

class DownloadedListRequest extends ListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter'      => 'array',
            'filter.type' => 'required|in:video,picture'
        ];
    }

    public function allowFilter(): array
    {
        return ['resource_type'];
    }

    public function allowSort(): array
    {
        return [];
    }

    public function prepareForValidation()
    {
        $filter = $this->query->get('filter');
        $filter['resource_type'] = $filter['type'];
        $this->query->set('filter', $filter);
    }
}
