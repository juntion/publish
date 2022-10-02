<?php
Route::post('/orders/customers/search', 'OrderController@getOrderInfo')->name('order.customer.search');

Route::post('/orders/search', 'OrderController@getOrderVouchInfo')->name('order.search');