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
Route::get('/classifications', 'Admin\AssessClassifyTreatmentController@classification');
Route::get('classifications/{id}', 'Admin\AssessClassifyTreatmentController@classification');
Route::get('signs-and-treatments/{id}', 'Admin\AssessClassifyTreatmentController@signsandtreatments');
Route::get('/followUpCare', 'Admin\FollowUpCareController@index')->name('follow_up');
Route::get('/treat', 'Admin\TreatController@index')->name('treat');
Route::get('/treat_ailments/{id}', 'Admin\TreatController@ailments');
Route::get('/treat_ailment_treatments/{id}', 'Admin\TreatController@treatments');
Route::get('/reviews', 'Admin\ReviewController@index')->name('reviews');
Route::get('/glossary', 'Admin\GlossaryController@index')->name('glossary');
Route::get('/ailments', 'Admin\AilmentsController@index');

// Submits

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

