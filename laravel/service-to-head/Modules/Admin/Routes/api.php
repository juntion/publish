<?php

//访问用户管理的权限，包含查看用户列表，用户拥有的角色，用户拥有的直接(临时)权限
Route::middleware(['permission:admin.view'])->group(function () {
    Route::get('admins', 'AdminController@index')->name('admins.index');
    Route::get('admins/{uuid}/rolesPermissions', 'AdminController@rolesPermissions')->name('admins.rolesPermissions');
});

//操作用户管理的权限，包含添加用户，更新用户，删除用户，设置用户的权限
Route::middleware(['permission:admin.action'])->group(function () {
    Route::post('admins', 'AdminController@store')->name('admins.store');
    Route::patch('admins/{uuid}', 'AdminController@update')->name('admins.update');
    Route::delete('admins/{uuid}', 'AdminController@destroy')->name('admins.destroy');
    Route::put('admins/{uuid}/rolesPermissions', 'AdminController@syncRolesPermissions')->name('admins.syncRolesPermissions');
});

// 获取用户列表
Route::get('admins/list','AdminController@getAdminList')->name('admins.list');