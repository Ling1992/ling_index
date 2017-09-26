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
    // 接口
    Route::get('getList/{like?}','IndexController@getList');
    // 内部接口
    Route::get('clearCache/{str}/{admin}', 'IndexController@clearCache')->where(['str' => '[0-9a-zA-Z]+', 'admin' => '[a-z]+']);
    // 添加 ip 到 黑名单
    Route::get('blacklist/addIp/{ips}/{admin}', 'IndexController@addIpToBlacklist')->where(['ips'=>'[0-9\.\,]+', 'admin'=>'[a-z]+']);



    // 后台界面 观察 ip
    Route::get('ipList', 'adminController@index');
    Route::get('ipDetail/{ip}/{date}', 'adminController@detail')->where(['ip'=>'[0-9\.]+', 'date'=>'[0-9\-]+']);
});

//Route::get('/test', 'Index\IndexController@test');

Route::get('/image/{width}/{height}', 'Index\ImageController@index')->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

//Route::group()
