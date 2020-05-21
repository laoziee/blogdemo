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

Route::get('/', function () {
    return view('welcome');
});
//添加页面路由
Route::get('user/add','UserController@add');
//添加数据保存
Route::post('user/store','UserController@store');
//列表显示页面
Route::get('user/index','UserController@index');
//修改页面
Route::get('user/edit/{id}','UserController@edit');
//修改数据保存
Route::post('user/update','UserController@update');
//删除操作
Route::get('user/del/{id}','UserController@destroy');
