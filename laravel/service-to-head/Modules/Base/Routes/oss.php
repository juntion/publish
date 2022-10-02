<?php

// oss 回调接口
Route::post('callback/upload', 'OssController@uploadCallback')->withoutMiddleware(['auth:admin'])->name('.callback.upload');
// 获取oss资源url
Route::get('signUrl', 'OssController@getOssUrl')->name('.signUrl');
// 获取post上传权限
Route::post('permission/upload', 'OssController@uploadPermission')->name('.permission.upload');
// 获取sts token
Route::post('STSToken/upload', 'OssController@stsToken')->name('.stsToken.upload');
