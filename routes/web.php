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
    return redirect('/login');
});

Route::get('/admin', 'Admin\DashboardController@index')->name('admin');
Route::get('/assess_classify_treatment', 'Admin\AssessClassifyTreatmentController@index')->name('assess_classify_treatment');
Route::get('/followUpCare', 'Admin\FollowUpCareController@index')->name('follow_up');
Route::get('/reviews', 'Admin\ReviewController@index')->name('reviews');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

