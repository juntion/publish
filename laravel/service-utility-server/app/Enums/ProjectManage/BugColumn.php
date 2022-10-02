<?php

namespace App\Enums\ProjectManage;

final class BugColumn
{
    const COLUMN_DESC = [
        'number'                 => '编号',
        'dept_id'                => '发布人部门ID',
        'dept_name'              => '发布人部门名称',
        'promulgator_id'         => '发布人ID',
        'promulgator_name'       => '发布人名称',
        'status'                 => '状态',
        'examine_status'         => '审批状态',
        'is_urgent'              => '是否加急',
        'description'            => '故障描述',
        'operation_account'      => '操作账号',
        'browser'                => '浏览器',
        'start_time'             => '故障开始时间',
        'end_time'               => '故障结束时间',
        'operation_platform'     => '操作平台',
        'links'                  => '页面链接',
        'version'                => '软件版本号',
        'source_project_id'      => '所属项目ID',
        'source_project_name'    => '所属项目名称',
        'source_demand_id'       => '所属需求ID',
        'source_demand_name'     => '所属需求名称',
        'product_principal_id'   => '产品负责人ID',
        'product_principal_name' => '产品负责人名称',
        'program_principal_id'   => '程序负责人ID',
        'program_principal_name' => '程序负责人名称',
        'test_principal_id'      => '测试负责人ID',
        'test_principal_name'    => '测试负责人名称',
        'expiration_date'        => '截至日期',
        'comment'                => '备注',
        'resolve_status'         => '问题解决状态',
        'solution'               => '解决方案',
        'reason_id'              => '原因类型ID',
        'reason_analyse'         => '原因分析说明',
        'data_restore'           => '数据修复情况',
        'data_restore_comment'   => '数据修复情况说明',
        'inquiry_progress'       => '调查进展',
        'start_handle_time'      => '开始处理时间',
        'submit_time'            => '提交时间',
        'finish_time'            => '完成时间',
    ];
}
