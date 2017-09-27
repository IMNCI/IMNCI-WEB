<?php

use Illuminate\Http\Request;
use App\AppUser;
use App\AgeGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('appuser/get', 'AppUserController@getappuser');
Route::post('appuser/add', 'AppUserController@addappuser');
Route::post('review', 'ReviewController@store');
Route::post('ailment', 'AilmentsController@store');
Route::get('ailment', 'AilmentsController@index');
Route::post('followupbyailment', 'API\FollowUpCareController@getbyailment');
Route::get('ailments/{age_group_id}', 'AilmentsController@ailmentbyage');
Route::post('/addAdvice', 'API\FollowUpCareController@addAdvice');
Route::post('/addTreatment', 'API\FollowUpCareController@addTreatment');


Route::get('/ailment-followup', 'API\FollowUpCareController@get');
Route::get('agegroups', function(){
	if (count(AgeGroup::all()) == 0) {
		$data1 = array('age_group'	=>	'Age upto 2 Months');
		$data2 = ['age_group'	=>	'2 Months upto Years'];
		AgeGroup::create($data1);
		AgeGroup::create($data2);
	}
	
	return AgeGroup::all();
});