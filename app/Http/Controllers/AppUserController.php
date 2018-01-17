<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppUser;

class AppUserController extends Controller
{
    public function getappuser(){
    	return AppUser::all();
    }

    public function addappuser(Request $request){
    	$display_no = $request->input('display_no');

    	$appuser = AppUser::where('display_no', $display_no)->first();
    	if ($appuser) {
    		$appuser->phone_id = $request->input('phone_id');
            $appuser->opened_at = $request->input('opened_at');
            $appuser->brand = $request->input('brand');
            $appuser->model = $request->input('model');
            $appuser->device = $request->input('device');
            $appuser->android_version = $request->input('android_version');
            $appuser->display_no = $request->input('display_no');
            $appuser->android_sdk = $request->input('android_sdk');
            $appuser->android_release = $request->input('android_release');
            $appuser->device_model = $request->input('device_model');
            $appuser->save();
    	}else{
    		$appuser = AppUser::create($request->all());
    	}
    	return $appuser;
    }

    public function getBrandStatistics(){
        $brand_statistics = [];
        $brands = AppUser::select('brand', \DB::raw('count(*) as total'))->groupBy('brand')->get();
        foreach ($brands as $brand) {
            $brand_statistics[] = [
                'name'  =>  $brand->brand,
                'y'     =>  $brand->total
            ];
        }

        return $brand_statistics;
    }

    public function download(Request $request){
        $format = $request->format;

        $appusers = $this->getappuser();

        foreach ($appusers as $appuser) {
            $data[] = [
                'BRAND' => strtoupper($appuser->brand),
                'DEVICE' => strtoupper($appuser->device),
                'MODEL' => strtoupper($appuser->model),
                'ANDROID VERSION' => "Android {$appuser->android_release}",
                'DOWNLOAD DATE' => date('d.m.Y \a\t h:i a', strtotime($appuser->created_at))
            ];
        }

        \Excel::create('DownloadHistory', function($excel) use($data) {
            // Set the title
            $excel->setTitle('IMNCI Application Download History');

            // Chain the setters
            $excel->setCreator('IMNCI Export Bot')
                    ->setCompany('IMNCI');

            // Call them separately
            $excel->setDescription('These are the users that have downloaded the IMNCI Application as of ' . date('d/M/Y'));

            $excel->sheet('Phones Listing', function($sheet) use($data) {
                $sheet->setAutoSize(true);
                $sheet->cells('A1:E1', function($cells){
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }
}
