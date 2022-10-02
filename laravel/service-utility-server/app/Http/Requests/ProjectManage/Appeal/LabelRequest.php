<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('labels', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'label_ids' => 'array',
            'label_ids.*' => 'integer|exists:pm_labels,id',
        ];
    }

    public function attributes()
    {
        return [
            'label_ids' => '诉求ID集合',
            'label_ids.*' => '诉求ID',
        ];
    }
}
