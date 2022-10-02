<?php

namespace Modules\Share\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResourceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'resources'            => 'required|array',
            'resources.*.uuid'     => 'required|exists:Modules\Base\Entities\Base\OssTempUpload,uuid',
            'resources.*.name'     => 'required',
            'resources.*.duration' => 'required|int',
            'type'                 => 'required|in:video,picture',
            'category_uuid'        => [
                'required',
                Rule::exists('share_resource_categories', 'uuid')->whereNull('deleted_at')
            ],
            'custom_category_uuid' => 'exists:Modules\Share\Entities\ResourceCustomCategory,uuid',
            'tag_uuid'             => 'array',
            'tag_uuid.*'           => [
                'required',
                Rule::exists('share_resource_tags', 'uuid')->whereNull('deleted_at')
            ],
            'subject_uuid'         => 'array',
            'subject_uuid.*'       => [
                'required',
                Rule::exists('share_subjects', 'uuid')->whereNull('deleted_at')
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
