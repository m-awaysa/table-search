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
    return view('pages.real-live');
});
Route::get('/live-search-similarities', function () {
    return view('pages.real-live');
})->name('similarity');

Route::get('/live-search-shortest', function () {
    return view('pages.real-live-shortest');
})->name('shortest');

Route::get('/live-search-no-database', function () {
    return view('pages.no-database');
})->name('noDatabase');


