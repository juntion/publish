<?php
/**
 *  发票管理
 */

// 发票的操作权限，包括创建发票，作废发票


// 发票列表查看权限,包括访问发票列表，下载发票的清账表
Route::middleware(['permission:finance.invoice.invoices.view'])->group(function () {
    Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');

    Route::get('/invoices/clear/download', 'InvoiceController@clearDownload')->name('invoices.clear.download');
});

// 发票详情查看权限
Route::middleware(['permission:finance.invoice.invoices.detail'])->group(function () {
    Route::get('/invoices/{uuid}/relate', 'InvoiceController@relate')->name('invoices.relate');
});

/**
 * 发票 api接口开放给ERP系统调用
 */
Route::post('/api/invoices', 'InvoiceApiController@store')->name('api.store')->withoutMiddleware(['auth:admin'])->middleware(['open.auth']);
Route::patch('/api/invoices/clear', 'InvoiceApiController@clear')->name('api.clear')->withoutMiddleware(['auth:admin'])->middleware(['open.auth']);
Route::delete('/api/invoices/soft', 'InvoiceApiController@soft')->name('api.soft')->withoutMiddleware(['auth:admin'])->middleware(['open.auth']);
Route::post('/api/customer/uncleared/invoices', 'InvoiceApiController@customerUncleared')->name('api.uncleared')->withoutMiddleware(['auth:admin'])->middleware(['open.auth']);
