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
Route::get('user/add', 'UserController@add');
//添加数据保存
Route::post('user/store', 'UserController@store');
//列表显示页面
Route::get('user/index', 'UserController@index');
//修改页面
Route::get('user/edit/{id}', 'UserController@edit');
//修改数据保存
Route::post('user/update', 'UserController@update');
//删除操作
Route::get('user/del/{id}', 'UserController@destroy');

//后台登录页路由
Route::get('admin/login', 'admin\LoginController@login');

//后台测试页路由
Route::get('admin/test', 'admin\LoginController@test');

//后台登录操作
Route::match(['get', 'post'], 'admin/dologin', 'admin\LoginController@todoLogin');

/*Route::post('admin/dologin',[
    'uses' => 'admin\LoginController@todoLogin'
])->name('dologin');*/


Route::get('admin/jiami', 'admin\LoginController@setCrypt');


//路由前缀+中间件

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => 'isLogin'], function () {
    //后台主页
    Route::get('main', 'MainController@index');
    //后台会员统计
    Route::get('total', 'MainController@total');

    //后台欢迎页面
    Route::get('welcome', 'LoginController@welcome');

    //后台登出方法
    Route::get('logout', 'LoginController@logout');

    Route::post('user/del','UserController@delAll');

    //后台用户路由
    Route::resource('user','UserController');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
