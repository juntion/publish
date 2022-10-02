<?php

/**
 * 用款凭证管理
 */

// 用款凭证的操作权限，包括创建用款凭证
Route::middleware(['permission:finance.voucher.vouchers.action'])->group(function () {
    Route::post('/vouchers', 'VoucherController@store')->name('vouchers.store');
});

// 凭证列表查看权限
Route::middleware(['permission:finance.voucher.vouchers.view'])->group(function () {
    Route::get('/vouchers', 'VoucherController@index')->name('vouchers.index');
    Route::get('/vouchers/download', 'VoucherController@voucherListDownload')->name('vouchers.list.download');
});

// api接口开放给ERP系统调用
Route::prefix('/api')->name('api.')->group(function () {
    Route::post('/vouchers', 'VoucherController@apiVouchersStore')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('vouchers.store');
    Route::post('/vouchers/split', 'VoucherController@apiSplit')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('vouchers.split');
    Route::patch('/vouchers/revoke', 'VoucherController@apiRevoke')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('vouchers.revoke');
});
