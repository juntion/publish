<?php

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

// 分类相关接口
Route::name('category.')->prefix("category")->namespace('Category')->group(function () {
    Route::get('/top/categories', 'CategoryController@topCategories')->name('top.categories');
    Route::get('/categories/{uuid}/categories', 'CategoryController@categories')->name('categories');
    Route::middleware(['permission:share.category.categories.action'])->group(function () {
        Route::post('/categories', 'CategoryController@store')->name('store');
        Route::patch('/categories/{uuid}', 'CategoryController@update')->name('update');
        Route::patch('/categories/{uuid}/close', 'CategoryController@close')->name('close');
        Route::patch('/categories/{uuid}/open', 'CategoryController@open')->name('open');
        Route::delete('/categories/{uuid}', 'CategoryController@delete')->name('delete');
        Route::patch('/trees/{type}', 'CategoryController@sort')->name('sort');
    });
    Route::get('/trees/{type}', 'CategoryController@treeType')->name('tree.type');
    Route::post('/categories/{uuid}/resourcesTagsCollection', 'CategoryController@resourcesTags')->name('resources.tags');
    Route::post('/categoriesMixResources', 'CategoryController@getCategoriesMixCollectionList')->name('categories.mix.collection');
});

// subject 相关接口
Route::name('subject.')->prefix('subject')->namespace('Subject')->group(function () {
    Route::get('/subjects', 'SubjectController@index')->name('subjects');
    Route::middleware(['permission:share.subject.subjects.action'])->group(function () {
        Route::post('/subjects', 'SubjectController@store')->name('store');
        Route::patch('/subjects/{uuid}', 'SubjectController@update')->name('update');
        Route::patch('/subjects/{uuid}/close', 'SubjectController@close')->name('close');
        Route::patch('/subjects/{uuid}/open', 'SubjectController@open')->name('open');
        Route::delete('/subjects/{uuid}', 'SubjectController@delete')->name('delete');
    });
    Route::post('/subjects/{uuid}/resourcesTagsCollection', 'SubjectController@resourcesTags')->name('resources.tags');
    Route::post('/search/subjects', 'SubjectController@search')->name('search');
});

// tag 相关接口
Route::name('tag.')->prefix('tag')->namespace('Tag')->group(function () {
    Route::get('/tags', 'TagController@tags')->name('tags');
    Route::post('/search/tags', 'TagController@searchTags')->name('search.tag');
    Route::middleware(['permission:share.tag.tags.action'])->group(function () {
        Route::post('/tags', 'TagController@store')->name('store');
        Route::patch('/tags/{uuid}', 'TagController@update')->name('update');
        Route::delete('/tags/{uuid}', 'TagController@delete')->name('delete');
        Route::patch('/tags/{uuid}/close', 'TagController@close')->name('close');
        Route::patch('/tags/{uuid}/open', 'TagController@open')->name('open');
    });
});

// 用户相关

Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
    // 用户收藏相关
    Route::name('collection.')->prefix('collection')->group(function () {
        Route::get('/top/categories', 'CollectionController@topCategories')->name('top.categories');
        Route::get('/categories/{uuid}/categories', 'CollectionController@categories')->name('categories');
        Route::post('/categories', 'CollectionController@store')->name('store.categories');
        Route::patch('/categories/{uuid}', 'CollectionController@update')->name('update.categories');
        Route::delete('/categories/{uuid}', 'CollectionController@delete')->name('delete.categories');
        Route::post('/collections', 'CollectionController@collections')->name('collections');
        Route::post('/collections/batch', 'CollectionController@batchCollection')->name('batch.collections');
        Route::delete('collections/batch', 'CollectionController@batchDeleteCollection')->name('batch.delete.collection');
        Route::delete('collections/{uuid}', 'CollectionController@deleteCollection')->name('delete.collection');
        Route::post('categoriesMixCollections', 'CollectionController@getCategoriesMixCollectionList')->name('categories.mix.collection');
    });
    // 用户上传相关
    Route::name('upload.')->prefix('upload')->group(function () {
        Route::get('/top/categories', 'UploadController@topCategories')->name('top.categories');
        Route::get('/categories/{uuid}/categories', 'UploadController@categories')->name('categories');
        Route::post('/categories', 'UploadController@store')->name('store.categories');
        Route::patch('/categories/{uuid}', 'UploadController@update')->name('update.categories');
        Route::delete('/categories/{uuid}', 'UploadController@delete')->name('delete.categories');
        Route::post('/categoriesMixResources', 'UploadController@getCategoriesMixCollectionList')->name('categories.mix.collection');
    });
    // 用户其他接口
    Route::get('/stats', 'AdminController@getStats')->name('stats');
    Route::post('/vieweds', 'AdminController@getViewedList')->name('vieweds');
    Route::post('/downloads', 'AdminController@getDownloadList')->name('downloads');
});

// 搜索相关接口

Route::name('search.')->prefix('search')->namespace('Search')->group(function () {
    Route::get('/hot/keys', 'SearchController@hotKeys')->name('hot.keys');
    Route::post('/keysTags', 'SearchController@keysTags')->name('keys.tags');
});

// resource 相关接口
Route::name('resource.')->prefix('resource')->namespace('Resource')->group(function () {
    Route::get('/resourcesTagsCollection', 'ResourceController@resourcesTagsCollectionList')->name('tags.collections.list');
    Route::get('/resourcesCategoriesTagsCollection/{uuid}', 'ResourceController@getResourceInfo')->name('categories.tags.collection');
    Route::post('/resources', 'ResourceController@store')->name('store');
    Route::patch('/resources/batch', 'ResourceController@batchUpdateResource')->name('batch.update');
    Route::patch('/resources/{uuid}', 'ResourceController@updateResource')->name('update');
    Route::delete('/resources/batch', 'ResourceController@batchDeleteResource')->name('batch.delete');
    Route::delete('/resources/{uuid}', 'ResourceController@deleteResource')->name('delete');
    Route::post('/resources/{uuid}/download', 'ResourceController@downloadResource')->name('download');
    Route::post('/resources/downloadBatch', 'ResourceController@batchDownloadResource')->name('batch.download');
    Route::post('/search/resourcesTagsCollection', 'ResourceController@searchResourcesTagsCollection')->name('tags.collection');
    Route::post('/resources/{uuid}/categories', 'ResourceController@addNewCategory')->name('add.category');
    Route::patch('/resources/{uuid}/categories', 'ResourceController@updateCategory')->name('update.category');
    Route::get('/resources/{uuid}/logs', 'ResourceController@getLogs')->name('logs');
    Route::post('/resources/{uuid}/tags', 'ResourceController@addTag')->name('add.tag');
    Route::delete('/resources/{resource_uuid}/tags/{tag_uuid}', 'ResourceController@deleteTag')->name('delete.tag');
});

