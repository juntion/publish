<?php

// 公司相关信息管理
Route::namespace("Company")->group(function (){
    Route::middleware(['permission:base.company.list.view'])->group(function (){
        Route::get('/companies', 'CompanyController@companies')->name('companies');
        Route::get('/companies/{uuid}/statusLogs', 'CompanyController@getStatusLog')->name('statusLog');
        Route::get('/companies/all/info', 'CompanyController@getAllInfo')->name('allCompanyInfo');
        Route::get('/companies/{uuid}/info', 'CompanyController@getInfo')->name('companyInfo');

    });

    Route::get('/companies/list', 'CompanyController@companiesList')->name('companies.list');

    Route::middleware(['permission:base.company.list.action'])->group(function (){
        Route::post('/companies', 'CompanyController@store')->name('store');
        Route::patch('/companies/{uuid}', 'CompanyController@update')->name('update');
        Route::patch('/companies/{uuid}/status', 'CompanyController@changeStatus')->name('changeStatus');
    });

    Route::middleware(['permission:base.company.info.action'])->group(function (){
        // 注册信息
        Route::post('/companies/{uuid}/registration/addresses', 'CompanyController@storeRegistrationAddress')->name('storeRegistrationAddress');
        Route::post('/companies/registration/addresses/{uuid}/', 'CompanyController@updateRegistrationAddress')->name('updateRegistrationAddress');
        // 办公室
        Route::post('/companies/{uuid}/office/addresses', 'CompanyController@storeOfficeAddress')->name('storeOfficeAddress');
        Route::post('/companies/office/addresses/{uuid}', 'CompanyController@updateOfficeAddress')->name('updateOfficeAddress');
        Route::patch('/companies/office/addresses/{uuid}/status', 'CompanyController@updateOfficeAddressStatus')->name('updateOfficeAddressStatus');
        // 仓库信息
        Route::post('/companies/{uuid}/warehouse/addresses', 'CompanyController@storeWarehouseAddress')->name('storeWarehouseAddress');
        Route::post('/companies/warehouse/addresses/{uuid}', 'CompanyController@updateWarehouseAddress')->name('updateWarehouseAddress');
        Route::patch('/companies/warehouse/addresses/{uuid}/status', 'CompanyController@updateWarehouseAddressStatus')->name('updateWarehouseAddressStatus');
        // 银行信息相关
        Route::post('/companies/{uuid}/bank', 'CompanyController@storeBank')->name('storeBank');
        Route::post('/companies/bank/{uuid}', 'CompanyController@updateBank')->name('updateBank');
        Route::patch('/companies/bank/{uuid}/status', 'CompanyController@updateBankStatus')->name('updateBankStatus');
    });

    Route::middleware(['permission:base.company.info.view'])->prefix('/companies')->group(function (){
        Route::get('/{uuid}/office/addresses', 'CompanyController@getOfficeInfo')->name('getOfficeInfo');
        Route::get('/office/addresses/{uuid}/statusLogs', 'CompanyController@getOfficeStatusLogs')->name('getOfficeStatusLogs');
        Route::get('/{uuid}/warehouse/addresses', 'CompanyController@getWarehouseInfo')->name('getWarehouseInfo');
        Route::get('/warehouse/addresses/{uuid}/statusLogs', 'CompanyController@getWarehouseStatusLogs')->name('getWarehouseStatusLogs');

        Route::get('/{uuid}/bank', 'CompanyController@getBankInfo')->name('getBankInfo');
        Route::get('/bank/{uuid}/statusLogs', 'CompanyController@getBankStatusLogs')->name('getBankStatusLogs');
    });

    Route::get('/companies/all', 'CompanyController@getTypeCompanies')->name('getTypeCompanies');
    Route::get('/media/download/{uuid}', 'CompanyController@download')->name('download');
});
