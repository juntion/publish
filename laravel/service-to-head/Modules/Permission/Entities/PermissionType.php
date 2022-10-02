<?php

namespace Modules\Permission\Entities;

trait PermissionType
{
    /**
     * 权限分类
     *  admin 后台权限
     *       -  PERMISSION_FEATURE 功能权限
     *       -  PERMISSION_ROUTE   访问入口权限
     *       -  PERMISSION_INDEX   访问首页权限
     *
     *  可添加权限分类
     *  other 其他权限
     *       -  PERMISSION_FEATURE 功能权限
     *       -  PERMISSION_ROUTE   访问入口权限
     *       -  PERMISSION_INDEX   访问首页权限
     */
    public static $GUARD_ADMIN = 'admin';      // 使用的 guard
    public static $PERMISSION_FEATURE = 1;     // 功能权限
    public static $PERMISSION_ROUTE = 2;       // 访问入口权限
    public static $PERMISSION_INDEX = 3;       // 访问首页权限
}
