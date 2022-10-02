<?php

Route::patch('account', 'AccountController@update')->name('account');
Route::patch('password', 'PasswordController@update')->name('password');
Route::post('avatar', 'AvatarController@upload')->name('avatar');
