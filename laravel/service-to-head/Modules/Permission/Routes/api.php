<?php
/**
 * 获取当前登录用户的权限
 */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('fetchPermission', 'PermissionController@fetchPermission')->name('fetchPermission');
});

//访问权限管理的权限，包括角色列表,权限列表,角色对应的权限
Route::middleware(['permission:permission.view'])->group(function () {
    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::get('roles/{uuid}/permissions', 'RoleController@permissions')->name('roles.permissions');
    Route::get('roles/{uuid}/admins', 'RoleController@admins')->name('roles.admins');
    Route::get('permissions', 'PermissionController@index')->name('permissions.index');
    Route::get('groups/permissions', 'PermissionController@groups')->name('groups.permissions');
    Route::get('roles/permissions', 'RoleController@rolesPermissions')->name('roles.rolesPermissions');
});

//操作权限管理
Route::middleware(['permission:permission.action'])->group(function () {
    Route::post('roles', 'RoleController@store')->name('roles.store');
    Route::patch('roles/{uuid}', 'RoleController@update')->name('roles.update');
    Route::delete('roles/{uuid}', 'RoleController@destroy')->name('roles.destroy');
    Route::put('roles/{uuid}/permissions', 'RoleController@syncPermissions')->name('roles.syncPermissions');
});
