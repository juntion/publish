<?php

Route::middleware('guest:admin')->group(function () {
//        Route::post('/register', 'RegisterController@register')->name('register');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/fetchUser', 'LoginController@fetchUser')->name('fetchUser');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});
