<?php

use Illuminate\Http\Request;
use App\AppUser;
use App\AgeGroup;
use App\AsessmentClassficationCategory;
use App\Sample;
use App\DiseaseClassification;
use App\AssessmentClassfication;
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
Route::get('/delete-ailment/{id}', 'AilmentsController@delete');
Route::post('followupbyailment', 'API\FollowUpCareController@getbyailment');
Route::get('ailments/{age_group_id}', 'AilmentsController@ailmentbyage');
Route::post('/addAdvice', 'API\FollowUpCareController@addAdvice');
Route::post('/addTreatment', 'API\FollowUpCareController@addTreatment');
Route::post('/addAdviceTreatment', 'API\FollowUpCareController@addAdiveTreatment');
Route::post('/get_assessment_classification_treatment', 'API\AssessClassifyTreatmentController@get');
Route::post('/assessment', 'API\AssessmentController@create');
Route::get('/assessment', 'API\AssessmentController@all');
Route::post('/get-assessments', 'API\AssessmentController@index');
Route::get('/assessment/{id}', 'API\AssessmentController@get');
Route::post('/classification', 'API\AssessmentController@add_assessment_classification');
Route::get('/classifications', 'API\AssessmentController@all_classifications');
Route::get('/classification/{id}', 'API\AssessmentController@get_classification');

Route::get('/signs', 'API\AssessmentClassificationSignController@index');
Route::post('/sign', 'API\AssessmentClassificationSignController@store');

Route::get('/treatments', 'API\AssessmentClassificationTreatmentController@index');
Route::post('/treatment', 'API\AssessmentClassificationTreatmentController@store');

Route::post('/glossary', 'API\GlossaryController@store');
Route::delete('/glossary/{id}', 'API\GlossaryController@delete');

Route::get('/signs/{classification_id}', 'API\AssessmentClassificationSignController@get_by_classification');
Route::get('/treatments/{classification_id}', 'API\AssessmentClassificationTreatmentController@get_by_classification');
Route::get('/remove-classification/{classification_id}', 'API\ClassificationController@remove');
Route::get("/get-classification-parents/{assessment_id}", function(Request $request){
	$parents = AssessmentClassfication::where('assessment_id', $request->assessment_id)->where('parent', '!=', null)->distinct()->get(['parent']);
	$response = [];

	if ($parents) {
		foreach ($parents as $parent) {
			$response[] = $parent->parent;
		}
	}

	return response()->json($response);
});


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

Route::get('assessment_class_group', function(){
	if (count(AsessmentClassficationCategory::all()) == 0) {
		$data = [
			[
				'group'	=>	"General Danger Signs"
			],
			[
				'group'	=>	"Main Symptoms"
			],
			[
				'group'	=>	"Checks"
			],
			[
				'group'	=>	'Ask For'
			],
			[
				'group'	=>	'Assess For'
			],
			[
				'group'	=>	'Others'
			]
		];

		AsessmentClassficationCategory::insert($data);
	}
	$response = [];
	$categories = AsessmentClassficationCategory::all();
	foreach ($categories as $category) {
		$response[] = [
			'id'		=>	$category->id,
			'category'	=>	$category->group
		];
	}

	return response()->json($response);
});

Route::get('sample', function(){
	return Sample::create([
		'sample'	=>	'Something'
	]);
});

Route::get('disease_classfication', function(){
	$data1 = [
		'classification'	=>	'Severe Classification',
		'description'		=>	'Severe Classification needing admission or pre-referral treatment and referral',
		'color'				=>	'#FF69B4'
	];

	$data2 = [
		'classification'	=>	'Normal Classification',
		'description'		=>	'A classification needing specific medical treatment and advice',
		'color'				=>	'#FFD700'
	];

	$data3 = [
		'classification'	=>	'Not Serious Classification',
		'description'		=>	'Not serious and in most cases no drugs are needed. Simple advice on home management given',
		'color'				=>	'#32CD32'
	];

	if(!DiseaseClassification::count()){

		DiseaseClassification::create($data1);
		DiseaseClassification::create($data2);
		DiseaseClassification::create($data3);
	}

	return DiseaseClassification::all();
});