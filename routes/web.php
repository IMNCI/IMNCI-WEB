<?php

// use Mail;
use App\Mail\DatabaseMailer;

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
Route::get('/counsel-the-mother', 'Admin\CounselTheMotherController@index')->name('counsel_the_mother');
Route::get('/counsel-subtitles/{title_id}', 'Admin\CounselTheMotherController@subtitles');
Route::get('/treat', 'Admin\TreatController@index')->name('treat');
Route::get('/treat_ailments/{id}', 'Admin\TreatController@ailments');
Route::get('/treat_ailment_treatments/{id}', 'Admin\TreatController@treatments');
Route::get('/reported-issues', 'Admin\ReviewController@index')->name('reported-issues');
Route::get('/hiv-care', 'Admin\HIVCareController@index')->name('hiv_care');
Route::post('/hiv-care', 'Admin\HIVCareController@store')->name('hiv_care_submit');
Route::post('/hiv-care-delete', 'Admin\HIVCareController@destroy')->name('hiv_care_destroy');
Route::get('/glossary', 'Admin\GlossaryController@index')->name('glossary');
Route::get('/ailments', 'Admin\AilmentsController@index');

Route::get('/gallery', 'Admin\GalleryController@index')->name('gallery');
Route::get('/gallery/{id}', 'Admin\GalleryController@index')->name('gallery-with-ailment');
Route::get('/gallery-ailments', 'Admin\GalleryAilmentController@index');
Route::get('/gallery-ailments', 'Admin\GalleryAilmentController@index');
Route::post('/gallery-ailments', 'Admin\GalleryAilmentController@store');
Route::post('/add-gallery', 'Admin\GalleryController@store');
Route::post('/edit-gallery', 'Admin\GalleryController@update');

Route::get('/profiles', 'Admin\UserProfileController@index')->name('profile');

Route::get('/hcw-workers', 'Admin\HCWWorkersController@index')->name('hcw-workers');
Route::get('/hcw-send-sms/all', 'Admin\SendSMSController@allHCW')->name('hcw-send-sms');
Route::get('/hcw-send-sms/test', 'Admin\SendSMSController@testHCW')->name('hcw-send-test-sms');
Route::get('/hcw-send-sms/new-test', 'Admin\SendSMSController@test')->name('send-test');
Route::get('/sms/logs', 'Admin\SendSMSController@logs')->name('sms-log');

Route::get('storage/{folder}/{filename}', function($folder, $filename){
	$path = storage_path('app/public/' . $folder . '/' . $filename);
	// echo $path;die;
	if (!File::exists($path)){
		abort(404);
	}

	$file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('storage_images');

Route::get('testingbackup', function(){
	 $details = \Artisan::call('backup:mysql-dump', [
            '--compress'    =>  true
        ]);

	 echo $details;die;
	// $directory = storage_path('app/backups');
	// $files = File::allFiles($directory);
	// // $email = new DatabaseMailer($files);
 // //    Mail::to(env('BACKUP_EMAIL', 'c.otaalo@gmail.com'))->send($email);
	// foreach ($files as $file) {
	// 	echo $file->getPathname() . "<br/>";
	// 	// File::delete($file->getPathname());
	// }
});

Route::get('files/get/{id}', 'Admin\GalleryController@getFile')->name('getFile');
// Submits

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

