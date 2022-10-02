<?php

namespace App\Enums\ProjectManage;

final class DevTaskColumn
{
    const COLUMN_DESC = [
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
        'start_time'          => '开始时间',
        'pause_time'          => '暂停时间',
        'finish_time'         => '结束时间',
        'title'               => '任务标题',
        'share_address'       => '共享地址',
        'level'               => '任务等级',
    ];
}
