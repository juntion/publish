<?php

namespace App\Enums\Permission;

final class PermissionLogType
{
    // 权限相关日志类型
    // 1：角色权限变更(包括角色增删)；2：用户的角色变更 3：用户直接权限变更；4：角色的用户变更
    const ROLE_PERMISSION = 1;
    const ROLE_USER = 4;

    const USER_ROLE = 2;
    const USER_PERMISSION = 3;
}
