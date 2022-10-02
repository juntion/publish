<?php
# 开放平台接口
Route::name('open.auth.')->prefix("open/auth")->group(function () {
    # 列表
    Route::middleware(['permission:base.open.auth.view'])->group(function () {
        Route::get('tokens', 'OpenAuthController@index')->name('token.list');
    });
    # 操作接口
    Route::middleware(['permission:base.open.auth.action'])->group(function () {
        Route::post('token', 'OpenAuthController@store')->name('token.store');
        Route::patch('token/{uuid}/status', 'OpenAuthController@changeStatus')->name('token.status');
    });
    # open.auth中间件使用的请求头authorization和登录验证是一样，因此只能用其一
//    Route::get('token/test', function () {
//        return 123;
//    })->withoutMiddleware(['auth:admin'])->middleware(['open.auth']);
});
