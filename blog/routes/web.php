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

//Route::get('/{id?}', function () {
//    return view('welcome');
//});

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('c_id/{id?}', 'IndexController@index');
    Route::get('detail/{id}', 'IndexController@detail');
});

Route::group(['namespace' => 'Admin'], function() {
    Route::get('admin', ['as' => 'admin', 'uses' => 'LoginController@index']);
    Route::post('admin/check_account', 'LoginController@checkAccount');
    Route::post('admin/login', 'LoginController@login');
    Route::get('admin/article', 'ArticleController@lists');
    Route::get('admin/editor/{id?}', 'ArticleController@editor');
    Route::get('admin/change/{id}', 'ArticleController@change');
    Route::post('admin/save', 'ArticleController@save');
});
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
