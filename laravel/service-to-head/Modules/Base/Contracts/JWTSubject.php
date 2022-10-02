<?php
/**
 * 扩展JWT 的功能，
 * 问题描述：JWT的token一旦生成，服务器无法注销此token，只有等待token过期
 * 解决方案：给token设置一个版本号，同时存在服务器和token的载荷上，
 * 服务器和token的载荷上的版本号不相同则视为 token 无效，当服务器要注销token时，只需把服务器上的版本号加一即可
 */

namespace Modules\Base\Contracts;

use Tymon\JWTAuth\Contracts\JWTSubject as Subject;

interface JWTSubject extends Subject
{
    /**
     * 初始化服务端token的版本号
     */
    public function initJWTVersion();

    /**
     * 得到服务端token当前的版本号
     * @return int
     */
    public function getJWTVersion();

    /** 自增服务端token当前的版本号
     * @return int
     */
    public function incrementJWTVersion();

    /**
     * 销毁服务端token的版本号
     */
    public function destroyJWTVersion();
}