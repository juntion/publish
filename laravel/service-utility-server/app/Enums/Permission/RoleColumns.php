<?php

namespace App\Enums\Permission;

final class RoleColumns
{
    public const COLUMNS = [
        'name' => '角色名',
        'guard_name' => '系统标识',
        'comment' => '备注',
        'locale' => '多语言',
        'updated_at' => '修改时间',
        'created_at' => '创建时间',
    ];
}
