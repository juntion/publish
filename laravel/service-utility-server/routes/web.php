<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', 'Controller@welcome')->name('welcome.public');
Route::get('log-viewer', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth.basic:web,name');
Route::get('/webSocket', '\App\Http\Controllers\GatewayWorkerController@webSocket')->name('webSocket.public');
Route::post('/webSocket/push', '\App\Http\Controllers\GatewayWorkerController@push')->name('webSocket.push.public');
