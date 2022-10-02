<?php

/**
 * 到款凭证管理
 */

// 到款管理的操作权限，包括创建到款，到款导入，修改到款，取消到款，激活到款
Route::middleware(['permission:finance.receipt.receipts.action'])->group(function () {
    Route::post('/receipts', 'ReceiptController@store')->name('receipts.store'); // 创建到款
    Route::post('/receipts/upload', 'ReceiptController@upload')->name('receipts.upload'); // 表格上传批量创建到款
    Route::patch('/receipts/{uuid}', 'ReceiptController@update')->name('receipts.update'); // 编辑到款，更新到款
    Route::delete('/receipts/{uuid}/soft', 'ReceiptController@softDelete')->name('receipts.softDelete'); // 取消到款，软删除到款
    Route::post('/receipts/{uuid}/active', 'ReceiptController@active')->name('receipts.active');//激活到款
    Route::get('/receipts/{uuid}/download', 'ReceiptController@downloadUploadFailedData')->name('download.import.failed.data');// 下载导入失败的临时文件
});

// 到款的访问权限，包括访问到款列表，到款的附件下载
Route::middleware(['permission:finance.receipt.receipts.view'])->group(function () {
    Route::get('/receipts', 'ReceiptController@index')->name('receipts.index'); // 到款数据,到款列表

    Route::any('/receipts/files/download', 'ReceiptController@downloadFile')->name('receipts.download'); //附件下载
    Route::any('/receipts/download', 'ReceiptController@downloadList')->name('receipts.downloadList'); //列表数据下载
});

// 到款认领审请的操作权限 创建申请 删除申请
Route::middleware(['permission:finance.receipt.applications.action'])->group(function () {
    Route::post('/applications/claim', 'ReceiptController@storeClaim')->name('claim.store');
    Route::post('/applications/unclaim', 'ReceiptController@storeUnClaim')->name('unclaim.store');
    Route::delete('/applications/{uuid}', 'ReceiptController@deleteClaim')->name('claim.delete');
});

// 到款认领审请的审核权限，认领/取消认领申请审核权限
Route::middleware(['permission:finance.receipt.applications.verify'])->group(function () {
    Route::post('/applications/{uuid}/verify', 'ReceiptController@verifyClaim')->name('claim.verify');
});

// 到款详情的访问权限，包括访问到款详情
Route::middleware(['permission:finance.receipt.receipts.detail'])->group(function () {
    Route::post('/receipts/search', 'ReceiptController@search')->name('receipts.search');

    Route::get('/receipts/{uuid}', 'ReceiptController@detail')->name('receipts.detail'); // 到款数据,到款列表
    Route::get('/receipts/{uuid}/vouchers', 'ReceiptController@vouchers')->name('receipts.vouchers');
    Route::get('/receipts/{uuid}/vouchers/{vouchers_uuid}/details', 'ReceiptController@vouchersDetails')->name('receipts.vouchers.details');
    Route::get('/receipts/{uuid}/fees', 'ReceiptController@getFees')->name('receipts.fees');
    Route::get('/receipts/{uuid}/refunds', 'ReceiptController@getRefunds')->name('receipts.refunds');
    Route::get('/receipts/{uuid}/floats', 'ReceiptController@getFloats')->name('receipts.floats');
    Route::get('/receipts/{uuid}/prepays', 'ReceiptController@getPrepays')->name('receipts.prepays');
    Route::get('/receipts/{uuid}/applications', 'ReceiptController@getApplication')->name('receipts.application');
});


// api接口开放给ERP系统调用
Route::post('/api/receipts', 'ReceiptController@apiStore')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.store');
Route::delete('/api/receipts/soft', 'ReceiptController@apiSoftDelete')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.softDelete');

Route::post('/api/receipts/search', 'ReceiptController@apiSearch')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.search');

Route::post('/api/receipts/use', 'ReceiptController@apiUpdateUse')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.updateUse');
//Route::post('/api/receipts/usable', 'ReceiptController@apiUpdateUsable')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.updateUsable');
Route::post('/api/receipts/fee', 'ReceiptController@apiUpdateFee')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.updateFee');
Route::post('/api/receipts/float', 'ReceiptController@apiUpdateFloat')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.updateFloat');
Route::post('/api/customer/unused/receipts', 'ReceiptController@apiGetCustomerUnused')->withoutMiddleware(['auth:admin'])->middleware(['open.auth'])->name('api.receipts.getCustomerUnused');
