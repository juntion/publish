<?php

namespace App\Enums\ProjectManage;

final class AppealColumn
{
    const COLUMN_DESC = [
        'number' => '诉求编号',
        'name' => '诉求标题',
        'content' => '诉求内容',
        'brief' => '诉求简介',
        'type' => '诉求类型',
        'is_urgent' => '标签紧急',
        'is_important' => '重要标签',
        'source_project_id' => '来源项目ID',
        'source_project_name' => '项目来源名称',
        'expiration_date' => '截至日期',
        'status' => '诉求状态',
        'dept_id' => '诉求人部门ID',
        'dept_name' => '诉求人部门名称',
        'promulgator_id' => '发布人ID',
        'promulgator_name' => '发布人名称',
        'principal_user_id' => '产品负责人ID',
        'principal_user_name' => '产品负责人名称',
        'follower_id' => '产品跟进人ID',
        'follower_name' => '产品跟进人名称',
        'follow_time' => '开始跟进时间',
        'follow_type' => '跟进类型',
        'verify_user_id' => '审核人ID',
        'verify_user_name' => '审核人名称',
        'verify_time' => '审核时间',
        'comment' => '负责人备注',
        'comment_follower' => '跟进人备注',
        'origin_id' => '原始诉求ID',
        'demand_id' => '关联的需求ID',
        'questions' => '诉求问题及答案',
        'crux' => '症结点',
    ];
}
