<?php

namespace Modules\Base\Contracts;

use Modules\Base\Http\Requests\ListRequest;

interface ListServiceInterface
{
    /** 设置查询构造器
     * @param $builder
     * @return mixed
     */
    public function setBuilder($builder);

    /** 设置请求
     * @param ListRequest $request
     * @return mixed
     */
    public function setRequest(ListRequest $request);

    /** 根据请求，获取查询构造器对应的资源，即获取列表数据，分页或所有
     * @return mixed
     */
    public function getResource();
}
