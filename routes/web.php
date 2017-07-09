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
    Route::get('category/{category}', function($category){
        if ($category == 'new') {
            return redirect()->route('index');
        }
        return 'index__'.$category;
    });

});
