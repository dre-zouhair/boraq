<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');

Route::post('/login','Auth\LoginController@login');
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','is_admin']], function () {
    Route::get('users',function (){return view('users/index');})->name('users');
    Route::get('users/reset',function (){return view('users/reset_password');})->name('reset_password');
    Route::get('products',function (){return view('products/index');})->name('products');
    Route::get('clients',function (){return view('clients/index');})->name('clients');
    Route::get('resources',function (){return view('resources/index');})->name('resources');
    Route::get('facturs',function (){return view('facturs/index');})->name('facturs');

    Route::post('users/store','UserController@store')->name('UserStore');
    Route::post('users/update','UserController@update')->name('UserUpdate');

    Route::post('/logout','Auth\LoginController@logout')->name('logout');

    Route::post('users/add','UserController@store')->name('addUser');
    Route::post('users/all/update','UserController@update')->name('updateUser');
    Route::get('users/all','UserController@index')->name('allUsers');
    Route::get('users/all/edit','UserController@edit')->name('userId');
    Route::get('users/all/delete','UserController@destroy')->name('deleteUser');


    Route::get('products/all','ProductController@index')->name('allProducts');
    Route::post('products/add','ProductController@store')->name('addProduct');
    Route::get('products/all/edit','ProductController@edit')->name('productId');
    Route::post('products/all/update','ProductController@update')->name('updateProduct');
    Route::get('products/all/delete','ProductController@destroy')->name('deleteProduct');
    Route::get('products/all/available','ProductController@available')->name('availableProduct');



    Route::get('products/all/Serials','ProductController@AllSerials')->name('AllSerials');

    Route::get('clients/all','ClientController@index')->name('allClients');
    Route::get('clients/history','ClientController@history')->name('clientHistory');
    Route::get('clients/bill','ClientController@bill')->name('displayBill');
    Route::post('clients/show','ClientController@show')->name('showClient');


    Route::post('TEST','ProductController@TEST')->name('AddSerials');









});
