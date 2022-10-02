<?php

/**
 *  货币管理
 */

// 汇率获取
Route::post("/rates/search", "CurrencyController@search");
