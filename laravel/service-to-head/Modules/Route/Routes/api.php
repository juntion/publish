<?php
/**
 * ==========================
 * 侧边栏和入口 管理
 * ==========================
 *  menu : 菜单
 *  route : 入口
 *  menuTree ：菜单树，入口作为菜单的属性 ，而不作为树的节点
 *  menuRouteTree ：菜单入口树，菜单和入口 都作为树的节点
 */

/**
 * 获取当前登录用户的信息
 */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('fetchMenu', 'MenuController@fetchMenu')->name('fetchMenu');
});

// 访问入口管理的权限，包括入口列表，所有侧边栏，侧边栏的结构
Route::middleware(['permission:route.view'])->group(function () {
    Route::get('routes', 'RouteController@index')->name('routes.index');
    Route::get('menus/{uuid}/routes', 'MenuController@routes')->name('menus.routes');
    Route::get('menuRouteTrees/{guard}', 'MenuRouteTreeController@tree')->name('menuRouteTrees');
});

// 更改侧边栏的权限，包括创建侧边栏分类，修改侧边栏分类，侧边栏分类添加入口，侧边栏分类删除入口，移动侧边栏
Route::middleware(['permission:route.action'])->group(function () {
    Route::post('menus', 'MenuController@store')->name('menus.store');
    Route::patch('menus/{uuid}', 'MenuController@update')->name('menus.update');
    Route::post('menus/{uuid}/routes', 'MenuController@addRoutes')->name('menus.addRoutes');
    Route::patch('menuRouteTrees/{guard}', 'MenuRouteTreeController@update')->name('menuRouteTrees.update');
    Route::delete('menuRouteTrees/{guard}/nodes/{uuid}', 'MenuRouteTreeController@destroyNode')->name('menuRouteTrees.destroyNode');
});

//Route::get('menuTrees/{guard}/nodes/top', 'MenuTreeController@menuTreeNodeTop')->name('menuTrees.nodes.top');
//Route::get('menuTrees/{guard}/nodes/{uuid}', 'MenuTreeController@menuTreeNode')->name('menuTrees.nodes');




