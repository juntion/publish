<?php

use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\ProductController;
use Modules\Tag\Http\Controllers\TagApiController;
use Modules\Tag\Http\Controllers\TagBindingController;
use Modules\Tag\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:admin')->group(function () {

    // 产品及分类相关
    Route::get('/dataSource/productCategories', [ProductController::class, 'categoryList'])->name('tags.products.categories');
    Route::get('/dataSource/products', [ProductController::class, "productList"])->name('tags.products');

    Route::middleware(['permission:tag.tags.view'])->group(function () {
        Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
        Route::get('/tags/trees', [TagController::class, "trees"])->name('tags.trees');
        Route::get('/tags/{tag}/children', [TagController::class, "children"])->name('tags.children');
        Route::get('/tags/download', [TagController::class, "download"])->name('tags.download');
        Route::get('/tags/export', [TagController::class, "export"])->name('tags.export');
        Route::get('/tags/{tag}/logs', [TagController::class, "logs"])->name('tags.logs');
        Route::get('/tags/dropdownList', [TagController::class, "dropdownList"])->name('tags.dropdownList');
    });

    Route::middleware(['permission:tag.logs.view'])->group(function () {
        Route::get('/tags/logs', [TagController::class, "operationLogs"])->name('tags.operationLogs');
    });

    Route::middleware(['permission:tag.tags.action'])->group(function () {
        Route::post('/tags', [TagController::class, "store"])->name('tags.store');
        Route::post('/tags/{tag}/child', [TagController::class, "addChild"])->name('tags.addChild');
        Route::post('/tags/{tag}/update', [TagController::class, "update"])->name('tags.update');
        Route::patch('/tags/{tag}/updateStatus', [TagController::class, "updateStatus"])->name('tags.updateStatus');
        Route::patch('/tags/{tag}/move', [TagController::class, "move"])->name('tags.move');
        Route::post('/tags/upload', [TagController::class, "upload"])->name('tags.upload');
        Route::delete('/tags/{tag}', [TagController::class, "delete"])->name('tags.delete');
    });

    Route::middleware(['permission:tag.binding.view'])->group(function () {
        Route::get('/binding', [TagBindingController::class, 'index'])->name('binding.index');
        Route::get('/binding/tags', [TagBindingController::class, 'bindingTags'])->name('binding.tags');
        Route::get('/binding/download', [TagBindingController::class, 'download'])->name('binding.download');
        Route::get('/binding/export', [TagBindingController::class, 'export'])->name('binding.export');
    });

    // 标签绑定相关操作
    Route::middleware(['permission:tag.binding.action'])->group(function () {
        Route::post('/binding', [TagBindingController::class, 'store'])->name('binding.store');
        Route::patch('/binding/{tagDataSource}', [TagBindingController::class, 'update'])->name('binding.update');
        Route::delete('/binding/{tagDataSource}', [TagBindingController::class, 'unbind'])->name('binding.unbind');
        Route::post('/binding/batchUnbind', [TagBindingController::class, 'batchUnbind'])->name('binding.batchUnbind');
        Route::post('/binding/upload', [TagBindingController::class, 'upload'])->name('binding.upload');
    });

});

Route::middleware('auth.signature')->group(function () {
    // 对外接口
    Route::get('/api/tags', [TagApiController::class, 'tags'])->name('api.tags');
    Route::get('/api/source', [TagApiController::class, 'source'])->name('api.source');
    Route::get('/api/source/tags', [TagApiController::class, 'sourceTags'])->name('api.source.tags');
    Route::get('/api/source/search', [TagApiController::class, 'search'])->name('api.source.search');
    Route::patch('/api/tags', [TagApiController::class, 'update'])->name('api.tags.update');
    Route::patch('/api/tags/batch', [TagApiController::class, 'batchUpdate'])->name('api.tags.batchUpdate');

});
