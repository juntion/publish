<?php

Route::middleware('guest:admin')->group(function () {
    Route::post('/login', 'LoginController@login')->name('login');
});

