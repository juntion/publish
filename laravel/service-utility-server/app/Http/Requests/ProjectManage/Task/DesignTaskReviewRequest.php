<?php

namespace App\Http\Requests\ProjectManage\Task;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class DesignTaskReviewRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('review', $this->route('task'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'review_result' => 'required|integer|between:0,2',
            'review_comment' => 'string',
            'media' => 'array',
            'media.*' => 'file',
        ];
    }

    public function attributes()
    {
        return [
            'review_result' => '设计走查结果',
            'review_comment' => '设计走查备注',
            'media' => '附件',
        ];
    }
}
