<?php

namespace Modules\Permission\Entities;

trait PermissionGroup
{
    /*
     * 权限分组
     *
     */
    public static $groups = [
        'admin'=>[
            'home',            //首页权限
            'base',            //基础模块
            'permission',      //权限管理
            'route',           //入口管理
            'admin',           //用户管理
            'finance',         //财务系统
            'share',           //资源共享
            'tag',             //标签系统
        ]
    ];
}
