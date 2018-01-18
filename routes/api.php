<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AppUser;
use App\AgeGroup;
use App\AsessmentClassficationCategory;
use App\Sample;
use App\DiseaseClassification;
use App\AssessmentClassfication;
use App\county;
use App\GalleryItem;
use App\Gallery;
use Illuminate\Http\Response;
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
Route::get('appuser/download/{format}', 'AppUserController@download');
Route::get('appuser/brand-statistics', 'AppUserController@getBrandStatistics');
Route::get('appuser/monthly-downloads/{year}', 'AppUserController@getMonthlyDownloads');
Route::get('appuser/android-version-distribution', 'AppUserController@getAndroidVersionDistribution');
Route::post('review', 'ReviewController@store');
Route::post('review/update', 'ReviewController@update');
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
Route::delete('/assessment/{id}', 'API\AssessmentController@destroy');
Route::post('/get-assessments', 'API\AssessmentController@index');
Route::get('/assessment/{id}', 'API\AssessmentController@get');
Route::post('/classification', 'API\AssessmentController@add_assessment_classification');
Route::get('/classifications', 'API\AssessmentController@all_classifications');
Route::get('/classification/{id}', 'API\AssessmentController@get_classification');

Route::post('/profile', 'API\UserProfileController@store');
Route::get('/profile/gender-statistics', 'API\UserProfileController@genderStatistics');
Route::get('/profile/cohort-statistics', 'API\UserProfileController@cohortStatistics');
Route::get('/profile/sector-statistics', 'API\UserProfileController@sectorStatistics');
Route::get('/profile/cadre-statistics', 'API\UserProfileController@cadreStatistics');
Route::get('/profile/profession-statistics', 'API\UserProfileController@professionStatistics');
Route::get('/profile/county-statistics', 'API\UserProfileController@countyStatistics');

Route::get('/signs', 'API\AssessmentClassificationSignController@index');
Route::post('/sign', 'API\AssessmentClassificationSignController@store');

Route::get('/treatments', 'API\AssessmentClassificationTreatmentController@index');
Route::post('/treatment', 'API\AssessmentClassificationTreatmentController@store');

Route::get('/glossary', 'API\GlossaryController@index');
Route::post('/glossary', 'API\GlossaryController@store');
Route::delete('/glossary/{id}', 'API\GlossaryController@delete');

Route::post('title', 'API\TreatController@store');
Route::get('titles', 'API\TreatController@index');
Route::post('remove-treat-title', 'API\TreatController@destroy');
Route::post('remove-treat-ailment', 'API\TreatController@destroyAilment');

Route::get('treat_ailments', 'API\TreatController@ailments');
Route::get('treat_ailment_treatments', 'API\TreatController@treatments');

Route::post('treat_ailment', 'API\TreatController@storeAilments');
Route::post('treat_ailment_treatments', 'API\TreatController@storeTreatment');
Route::delete('treat_ailment_treatments', 'API\TreatController@destroyTreatment');

Route::get('counsel-titles', 'API\CounselTheMotherController@index');
Route::post('counsel-title', 'API\CounselTheMotherController@store');
Route::delete('counsel-title', 'API\CounselTheMotherController@delete');
Route::get('counsel-sub-contents', 'API\CounselTheMotherController@all_sub_content');
Route::post('counsel-sub-content', 'API\CounselTheMotherController@store_sub_content');
Route::delete('counsel-sub-content', 'API\CounselTheMotherController@delete_sub_content');

Route::get('/signs/{classification_id}', 'API\AssessmentClassificationSignController@get_by_classification');
Route::get('/treatments/{classification_id}', 'API\AssessmentClassificationTreatmentController@get_by_classification');
Route::get('/remove-classification/{classification_id}', 'API\ClassificationController@remove');

Route::get('/hiv-care', 'API\HivCareController@index');

Route::get('/gallery', 'API\GalleryController@index');
Route::get('/gallery/view/{id}', 'API\GalleryController@getGalleryDetailsView');
Route::get('/gallery/edit/{id}', 'API\GalleryController@editView');
Route::get('/counties', function(Request $request){
	return county::all();
});

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

Route::get('galleryitems', function(){
	if (count(GalleryItem::all()) == 0) {
		$galleryitems = [
			"Job Aid", "Illustrations", "Video", "Guidelines", "Tools"
		];

		foreach ($galleryitems as $item) {
			$data = ['item'=>$item];

			GalleryItem::create($data);
		}
	}

	return GalleryItem::all();
});

Route::get('gallery-ailments', 'API\GalleryController@getGalleryAilments');

Route::delete('gallery/delete/{id}', 'API\GalleryController@remove');

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
				'group'	=>	"Check For"
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
		'classification'	=>	'Mild Classification',
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

Route::get('/files/get/{id}', function(Request $request){
	 $gallery = Gallery::findOrFail($request->id);

    $file = \Storage::disk('public')->get($gallery->link);

    return (new Response($file, 200))
            ->header('Content-Type', $gallery->mime);
});

Route::post('/check-last-update', function(Request $request){
	$last_app_update = date('Y-m-d H:i:s', strtotime($request->input('last_update')));

	$sql = "SELECT COUNT(UPDATE_TIME) as updated_count FROM information_schema.TABLES 
	WHERE TABLE_SCHEMA = '".env('DB_DATABASE')."' AND UPDATE_TIME > '".$last_app_update."'
	AND TABLE_NAME NOT IN ('app_users', 'users', 'jobs', 'failed_jobs', 'migrations', 'password_resets', 'user_profiles', 'reviews')";

	Storage::disk('local')->put('sql.txt', $sql);

	$update = DB::select($sql);
	if ($update[0]->updated_count > 0) {
		$message = ($update[0]->updated_count == 1) ? "There is an update available" : "There are updates available";
		return [
			'status'	=>	true,
			'message'	=>	$message
		];
	}else{
		return [
			'status'	=>	false,
			'message'	=>	'There is no update'
		];
	}
});