<?php

return [
    'name' => 'Permission',

    'models' => [
        'permission' => Modules\Permission\Entities\Permission::class,

        'role' => Modules\Permission\Entities\Role::class,
    ],

    'table_names' => [
        'roles' => 'roles',

        'permissions' => 'permissions',

        'model_has_permissions' => 'model_has_permissions',

        'model_has_roles' => 'model_has_roles',

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'model_morph_key' => 'model_uuid',
    ],
];
