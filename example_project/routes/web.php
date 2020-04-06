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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

Route::get('/', function () {
    if(isset($_GET['session'], $_GET['shop']))
        return redirect("product/?shop={$_GET['shop']}");
    return redirect("shop/?shop={$_GET['shop']}");
    // return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('shop', 'ShopController');
Route::resource('product', 'ProductController');
Route::resource('auth', 'AuthController');
Route::resource('message', 'MessageController');
