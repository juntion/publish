<?php

namespace App\Http\Requests\ProjectManage\Bug;

use Illuminate\Foundation\Http\FormRequest;

class BugsStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dept_id'             => 'exists:departments,id',
            'operation_account'   => 'required|array',
            'operation_account.*' => 'required|exists:users,id',
            'browser'             => 'required|array',
            'browser.*'           => 'required|string',
            'start_time'          => 'required|date',
            'end_time'            => 'required|date',
            'operation_platform'  => 'required|integer|between:1,7',
            'is_urgent'           => 'integer|between:0,1',
            'links'               => 'array',
            'links.*'             => 'string',
            'version'             => 'string',
            'description'         => 'required|string',
            'media'               => 'array',
            'media.*'             => 'file',
            // 编辑时附件
            'new_media'           => 'array',
            'new_media.*'         => 'file',
            'old_media'           => 'array',
            'old_media.*'         => 'integer|exists:media,id',
            'product_line'        => 'integer|exists:pm_products,id',
            'product_id'          => 'integer|exists:pm_products,id',
            'source_project_id'   => 'integer|exists:pm_projects,id',
            'source_project_name' => 'string',
            'source_demand_id'    => 'integer|exists:pm_demands,id',
            'source_demand_name'  => 'string',
        ];

    }

    public function attributes()
    {
        return [
            'dept_id'             => '部门ID',
            'operation_account'   => '操作账号',
            'operation_account.*' => '操作账号',
            'browser'             => '浏览器',
            'browser.*'           => '浏览器',
            'start_time'          => '故障开始时间',
            'end_time'            => '故障结束时间',
            'operation_platform'  => '操作平台',
            'is_urgent'           => '是否加急',
            'links'               => '页面链接',
            'links.*'             => '页面链接',
            'version'             => '软件版本号',
            'description'         => '故障描述',
            'media'               => '附件',
            'media.*'             => '附件',
            'new_media'           => '新增附件',
            'new_media.*'         => '新增附件',
            'old_media'           => '已存在附件',
            'old_media.*'         => '已存在附件',
            'product_line'        => '所属产品线',
            'product_id'          => '所属产品',
            'source_project_id'   => '所属项目ID',
            'source_project_name' => '所属项目名称',
            'source_demand_id'    => '所属需求ID',
            'source_demand_name'  => '所属需求名称',
        ];
    }
}
