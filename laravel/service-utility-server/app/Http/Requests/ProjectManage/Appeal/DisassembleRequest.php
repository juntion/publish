<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class DisassembleRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('disassemble', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'appeals' => 'required|array',
            'appeals.*.name' => 'required|string',
            'appeals.*.brief' => 'string',
            'appeals.*.content' => 'required|string',
            'appeals.*.type' => 'required|integer',
            'appeals.*.is_urgent' => 'integer|in:0,1',
            'appeals.*.is_important' => 'integer|in:0,1',
            'appeals.*.questions' => 'array',
            'appeals.*.questions.urgent' => 'array',
            'appeals.*.questions.urgent.*.question' => 'string',
            'appeals.*.questions.urgent.*.answer' => 'string',
            'appeals.*.questions.important' => 'array',
            'appeals.*.questions.important.*.question' => 'string',
            'appeals.*.questions.important.*.answer' => 'string',
            'appeals.*.source_project_id' => 'integer|exists:pm_projects,id',
            'appeals.*.source_project_name' => 'string',
            'appeals.*.product_id' => 'required|integer|exists:pm_products,id',
            'appeals.*.product_modules' => 'array',
            'appeals.*.product_modules.*.module_id' => 'integer|exists:pm_products,id',
            'appeals.*.product_modules.*.label_ids' => 'array',
            'appeals.*.product_modules.*.label_ids.*' => 'integer|exists:pm_products,id',
            'appeals.*.attention_user_ids' => 'array',
            'appeals.*.attention_user_ids.*' => 'integer|exists:users,id',
            'appeals.*.media' => 'array',
            'appeals.*.media.*' => 'file',
            'comment' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'appeals' => '诉求集合',
            'appeals.*.name' => '诉求标题',
            'appeals.*.brief' => '诉求内容简介',
            'appeals.*.content' => '诉求内容',
            'appeals.*.type' => '诉求类型',
            'appeals.*.is_urgent' => '是否紧急',
            'appeals.*.is_important' => '是否重要',
            'appeals.*.questions' => '问题及回答',
            'appeals.*.source_project_id' => '项目来源ID',
            'appeals.*.source_project_name' => '项目来源名称',
            'appeals.*.product_id' => '所属产品ID',
            'appeals.*.product_modules' => '产品模块',
            'appeals.*.product_modules.*.module_id' => '产品模块ID',
            'appeals.*.product_modules.*.label_ids' => '模块标签',
            'appeals.*.product_modules.*.label_ids.*' => '模块标签ID',
            'appeals.*.attention_user_ids' => '需关注的用户',
            'appeals.*.media' => '附件',
            'comment' => '备注',
        ];
    }
}
