<?php

namespace App\Enums\ProjectManage;

final class DesignTaskColumn
{
    const COLUMN_DESC = [
        'title'               => '任务标题',
        'share_address'       => '共享地址',
        'number'              => '任务编号',
        'demand_id'           => '需求ID',
        'source_project_id'   => '项目来源ID',
        'promulgator_id'      => '发布人ID',
        'promulgator_name'    => '发布人名称',
        'principal_user_id'   => '负责人ID',
        'principal_user_name' => '负责人名称',
        'priority'            => '优先级',
        'expiration_date'     => '截至日期',
        'content'             => '任务描述',
        'status'              => '任务状态',
        'review'              => '设计走查',
        'reviewer_id'         => '设计走查人ID',
        'reviewer_name'       => '走查人名称',
        'review_result'       => '设计走查结果',
        'review_comment'      => '设计走查备注',
        'review_time'         => '走查时间',
        'start_time'          => '开始时间',
        'pause_time'          => '暂停时间',
        'finish_time'         => '结束时间',
        'design_type'         => '设计类型',
    ];
}
