<?php

namespace App\Http\Requests\ProjectManage\Bug;

use Illuminate\Foundation\Http\FormRequest;

class BugReexamineRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'resolve_status'       => 'required|integer|in:2,4,5,6',
            'solution'             => 'string',
            'reason_id'            => 'integer|exists:pm_bug_reason,id',
            'reason_analyse'       => 'string',
            'data_restore'         => 'integer|between:1,4',
            'data_restore_comment' => 'string',
            'comment'              => 'string',
            'is_qualified'         => 'required|integer|in:0,1'
        ];
    }

    public function attributes()
    {
        return [
            'resolve_status'       => '解决问题状态',
            'solution'             => '解决方案',
            'reason_id'            => '原因类型',
            'reason_analyse'       => '原因类型分析说明',
            'data_restore'         => '数据修复情况',
            'data_restore_comment' => '数据修复情况说明',
            'comment'              => '备注',
            'is_qualified'         => '是否合格',
        ];
    }
}