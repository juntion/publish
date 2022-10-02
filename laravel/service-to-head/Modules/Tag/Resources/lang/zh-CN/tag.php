<?php

return [
    'store_error' => '添加失败',
    'update_error' => '更新失败',
    'move_error' => '转移失败',
    'move_parent_uuid' => '父级标签不能为自己！',
    'move_parent_type' => '父级标签必须为相同类型！',
    'type_error' => '标签类型错误',
    'upload' => [
        'file_error' => '请上传正确的文件',
        'file_extensions' => '上传文件格式错误，仅支持xls,xlsx格式！',
        'parent_not_exists' => '名称为：:name 的父级标签不存在，请检查表格数据！',
        'tag_not_exists' => 'ID为: :number 的标签不存在，请检查表格数据！',
        'tag_name_not_exists' => '名称为：:name 的标签不存在，请检查表格数据！',
    ],
    'delete' => [
        'exists_children' => '存在子级标签，无法删除！',
        'exists_bindings' => '存在绑定关系，无法删除！',
    ],
];
