<?php

return [
    'store_error' => 'Add tag failed',
    'update_error' => 'Update tag failed',
    'move_error' => 'Move tag failed',
    'move_parent_uuid' => 'The parent tag cannot be self!',
    'move_parent_type' => 'The parent tag must be the same type!',
    'type_error' => 'Unknown tag type.',
    'upload' => [
        'file_error' => 'The uploaded file is error',
        'file_extensions' => 'The upload file extension is wrong, only xls and xlsx formats are supported!',
        'parent_not_exists' => 'The tag with name: :name has no parent tag, please check the table data!',
        'tag_not_exists' => 'The tag with ID: :number does not exist, please check the table data!',
        'tag_name_not_exists' => 'The tag with name: :name does not exist, please check the table data!',
    ],
    'delete' => [
        'exists_children' => 'The tag has child tags, cannot be deleted!',
        'exists_bindings' => 'The tag has binding relationship, cannot be deleted!',
    ],
];
