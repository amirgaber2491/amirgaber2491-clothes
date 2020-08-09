<?php


use App\Expense;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
Route::get('test', function (){
//    return view('test');
//    return now()->addDay()->shortAbsoluteDiffForHumans();
    $from = date('2020-07-28');
    $to = date('2020-08-11');
//    $to = now()->addDay()->format('Y-m-d');
    return Sale::sum('total_sales');
});
Route::post('test', function (Request $request){
    return $request->all();
})->name('test');
Auth::routes();

Route::group(['middleware'=>'auth'], function (){
    Route::get('/', 'ClothesController@index')->name('inputs');
    Route::post('/purchases', 'ClothesController@purchasesStore')->name('purchases');
    Route::post('/sales', 'ClothesController@salesStore')->name('sales');
    Route::post('/expenses', 'ClothesController@expensesStore')->name('expenses');
    Route::get('profile','ClothesController@userProfile')->name('user.profile');
    Route::post('profile','ClothesController@userUpdateData')->name('user.profile.update');
    Route::post('user/change/password', 'ClothesController@changeUserPassword');

    // Start Admin Routes
    Route::group(['middleware'=>'admin', 'prefix'=>'admin'], function (){
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('/users', 'AdminController@users')->name('admin.users');

        Route::get('/user/create', 'AdminController@createUser')->name('admin.user.create');
        Route::post('/user/store', 'AdminController@store')->name('admin.user.store');


        Route::get('/user/edit/{id}', 'AdminController@editUser')->name('admin.user.edit');
        Route::post('/user/update/{id}', 'AdminController@update')->name('admin.user.update');

        Route::post('admin/user/change/password/{id}', 'AdminController@changeAdminPassword')->name('admin.user.changePassword');

        Route::get('/user/data', 'AdminController@userData')->name('admin.user.data');
        Route::post('admin/user/destroy/{id}', 'AdminController@destroy')->name('admin.user.destroy');
        Route::post('admin/user/make/admin/{id}', 'AdminController@makeAdmin')->name('make.admin');
        Route::post('admin/user/remove/admin/{id}', 'AdminController@removeAdmin')->name('remove.admin');

    });
    // End Admin Routes


    Route::get('purchases/', 'ClothesController@purchasesIndex')->name('purchases.index');
    Route::get('sales/', 'ClothesController@salesIndex')->name('sales.index');
    Route::get('expenses/', 'ClothesController@expensesIndex')->name('expenses.index');



    Route::get('/purchases/search', 'ClothesController@purchasesSearch')->name('purchases.search');
    Route::get('/expenses/search', 'ClothesController@expensesSearch')->name('expenses.search');
    Route::get('/sales/search', 'ClothesController@salesSearch')->name('sales.search');
    Route::get('report', 'ClothesController@report')->name('report');
    Route::get('report/purchases/data', 'ClothesController@purchasesData')->name('purchases.data');
    Route::get('report/sales/data', 'ClothesController@salesData')->name('sales.data');
    Route::get('report/expenses/data', 'ClothesController@expensesData')->name('expenses.data');

});
Route::get('/home', 'HomeController@index');


