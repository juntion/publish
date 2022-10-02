<?php

namespace Modules\Tag\Enums;

final class TagDataColumn
{
    const COLUMN_DESC = [
        'number' => '标签编号',
        'name' => '标签名称',
        'parent_uuid' => '父级标签',
        'path' => '所有父级UUID',
        'level' => '级别',
        'status' => '状态',
        'locale' => '多语言',
        'type' => '标签类型',
        'url_name' => 'URL名称',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
    ];
}
