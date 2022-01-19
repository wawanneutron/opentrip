<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')
    ->name('home');

Route::get('/details/{slug}', 'DetailController@index')
    ->name('details');

// checkout
Route::post('/checkout/{id}', 'CheckoutController@process')
    ->name('checkout-process')
    ->middleware(['ensureUserRole:user', 'verified']);

Route::get('/checkout/{id}', 'CheckoutController@index')
    ->name('checkout')
    ->middleware(['ensureUserRole:user', 'verified']);

Route::post('/checkout/search-friend/{detail_id}', 'CheckoutController@searchFreand')
    ->name('serch-freand')
    ->middleware(['ensureUserRole:user', 'verified']);

Route::post('/checkout/create/{detail_id}', 'CheckoutController@create')
    ->name('checkout-add-friend')
    ->middleware(['ensureUserRole:user', 'verified']);

Route::delete('/checkout/remove/{detail_id}', 'CheckoutController@remove')
    ->name('checkout-remove')
    ->middleware(['ensureUserRole:user', 'verified']);

Route::get('/checkout/confirm/{id}', 'CheckoutController@succses')
    ->name('checkout-succses')
    ->Middleware(['ensureUserRole:user', 'verified']);

Route::middleware(['auth'])->group(function () {
    // admin dashboard
    Route::prefix('admin/dashboard')->namespace('Admin')
        ->name('admin.')
        ->middleware('ensureUserRole:admin')
        ->group(function () {
            Route::get('/', 'DashboardController@index')
                ->name('dashboard');
            Route::resource('travel-package', 'TravelPackageController');
            Route::resource('gallery', 'GalleryController');
            Route::resource('transaction', 'TransactionController');
        });

    // user dashboard
    Route::prefix('user/dashboard')->namespace('User')
        ->name('user.')
        ->middleware('ensureUserRole:user')
        ->group(function () {
            Route::get('/', 'DashboardUserController@index')->name('dashboard');
            Route::get('/history-transaction', 'DashboardUserController@historyTransaction')->name('dashboard-history');
            Route::get('/history-transaction/{id}', 'DashboardUserController@detailTransaction')->name('detail-transaction');
            Route::delete('/history-transaction/delete/{id}', 'DashboardUserController@destroy')->name('destory-incart');
        });
});

Auth::routes(['verify' => true]);

// Midtrans
Route::post('/midtrans/callback', 'MidtransController@notificationHandler');
Route::get('/midtrans/finish', 'MidtransController@finishRedirect');
Route::get('/midtrans/unfinish', 'MidtransController@unfinishRedirect');
Route::get('/midtrans/error', 'MidtransController@errorRedirect');
