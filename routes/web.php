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
    return view('index');
});

Route::get('/ban-hang', function () {
    return view('admins.contents.cart');
});

Route::get('/thuoc', function () {
    return view('admins.contents.products.list');
});
Route::get('/thuoc/them', function () {
    return view('admins.contents.products.add');
});
Route::get('/thuoc/{id}', function () {
    return view('admins.contents.products.edit');
});

Route::get('/nhap-hang', function () {
    return view('admins.contents.import_product.import');
});
Route::get('/nhap-hang/them', function () {
    return view('admins.contents.import_product.add');
});
Route::get('/nhap-hang/{id}', function () {
    return view('admins.contents.import_product.edit');
});


Route::get('/xuat-hang/', function () {
    return view('admins.contents.export_product.list');
});
Route::get('/xuat-hang/them', function () {
    return view('admins.contents.export_product.add');
});
Route::get('/xuat-hang/{}', function () {
    return view('admins.contents.export_product.edit');
});

Route::get('/kiem-kho', function () {
    return view('admins.contents.inventory.list');
});

Route::get('/kiem-kho/them', function () {
    return view('admins.contents.inventory.add');
});
Route::get('/kiem-kho/{id}', function () {
    return view('admins.contents.inventory.edit');
});

Route::get('/hoa-don', function () {
    return view('admins.contents.bills.list');
});
Route::get('/hoa-don/them', function () {
    return view('admins.contents.bills.add');
});
Route::get('/hoa-don/{id}', function () {
    return view('admins.contents.bills.edit');
});
Route::get('/nhan-vien', function () {
    return view('admins.contents.employees.list');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/setting', 'Admin\HomeController@getIndex')->name('home1');
//Route::get('/', 'HomeController@index');
