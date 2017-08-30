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



Route::group(['middleware' => 'ling_index','namespace' => 'Index'], function(){
    // 控制器在 "App\Http\Controllers\Index" 命名空间下

    Route::get('/', ['uses'=>'IndexController@Index','as'=>'index']);

    Route::get('category/new', function(){
        return redirect()->route('index');
    });

    Route::get('category/{category}','IndexController@category')->where('category','[a-z_]{3,}');

    Route::get('article/{id}',['uses'=>'IndexController@article','as'=>'article'])->where('id', '[0-9]+');

    Route::get('getList','IndexController@getList');
});

//Route::get('/test', 'Index\IndexController@test');

Route::get('/image/{width}/{height}', 'Index\ImageController@index')->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

//Route::group()
