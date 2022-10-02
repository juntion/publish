<?php
/**
 * Created by PhpStorm.
 * User: King
 * Date: 2020/9/8
 * Time: 10:41
 */

namespace App\Enums\User;


final class Duty
{
    const _DEFAULT = 0; // 默认无职级
    const GROUP_LEADER = 10; // 组长
    const GROUP_PRINCIPAL = 20; // 组负责人
    const PRINCIPAL = 30; // 组负责人
    const SUPERVISOR = 40; // 主管
    const MANAGER = 50; // 经理
    const DIRECTOR = 60; // 总监
}