<?php

namespace App\Http\Requests\ProjectManage\Task;

use App\Exceptions\System\InvalidStatusException;
use function Hprose\Future\filter;
use Illuminate\Foundation\Http\FormRequest;

class DesignTaskSequenceRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('sequence', $this->route('task'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'parts' => 'required|array',
            'parts.*' => 'required|integer|between:0,4',
            'design_type' => 'required|integer|between:0,2',
        ];
    }

    public function attributes()
    {
        return [
            'parts' => '设计环节',
            'parts.*' => '设计环节',
            'design_type' => '设计类型',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->request->has('parts')) {
            $parts = $this->request->get('parts');
            $parts = collect($parts)->filter(function ($item) {
                return !is_null($item);
            })->toArray();
            $this->offsetSet('parts', $parts);
        }
    }
}
