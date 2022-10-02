<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class AppealStoreRequest extends FormRequest
{
    /**
     * @return bool
     * @throws InvalidStatusException
     */
    public function authorize()
    {
        $appeal = $this->route('appeal');
        // 编辑诉求验证状态
        if ($appeal && !$this->user()->can('edit', $appeal)) {
            throw new InvalidStatusException();
        }
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('questions')) {
            $questions = $this->request->get('questions');
            if (is_string($questions)) {
                $this->request->set('questions', json_decode($questions, true));
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'brief' => 'string',
            'content' => 'required|string',
            'type' => 'required|integer',
            'is_urgent' => 'integer|in:0,1',
            'is_important' => 'integer|in:0,1',
            'questions' => 'array',
            'questions.urgent' => 'array',
            'questions.urgent.*.question' => 'string',
            'questions.urgent.*.answer' => 'string',
            'questions.important' => 'array',
            'questions.important.*.question' => 'string',
            'questions.important.*.answer' => 'string',
            'source_project_id' => 'integer|exists:pm_projects,id',
            'source_project_name' => 'string',
            'source_bug_id' => 'integer|exists:pm_bugs,id',
            'product_id' => 'required|integer|exists:pm_products,id',
            'product_modules' => 'array',
            'product_modules.*.module_id' => 'integer|exists:pm_products,id',
            'product_modules.*.label_ids' => 'array',
            'product_modules.*.label_ids.*' => 'integer|exists:pm_products,id',
            'attention_user_ids' => 'array',
            'attention_user_ids.*' => 'integer|exists:users,id',
            'media' => 'array',
            'media.*' => 'file',
            // 编辑时附件
            'new_media' => 'array',
            'new_media.*' => 'file',
            'old_media' => 'array',
            'old_media.*' => 'integer|exists:media,id'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '诉求标题',
            'brief' => '诉求内容简介',
            'content' => '诉求描述',
            'type' => '诉求类型',
            'is_urgent' => '是否紧急',
            'is_important' => '是否紧急重要',
            'questions' => '问题及回答',
            'source_project_id' => '项目来源ID',
            'source_project_name' => '项目来源名称',
            'source_bug_id' => '来源Bug ID',
            'product_id' => '所属产品ID',
            'product_modules' => '产品模块',
            'product_modules.*.module_id' => '产品模块ID',
            'product_modules.*.label_ids' => '模块标签',
            'product_modules.*.label_ids.*' => '模块标签ID',
            'attention_user_ids' => '需关注的用户',
            'media' => '附件',
            'new_media' => '新增附件',
            'old_media' => '已存在附件',
        ];
    }
}
