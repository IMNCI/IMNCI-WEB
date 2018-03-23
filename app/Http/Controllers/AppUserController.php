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
        $brands = AppUser::select('brand', \DB::raw('count(*) as total'))->groupBy('brand')->orderBy('total', 'DESC')->get();
        foreach ($brands as $brand) {
            $brand_statistics[] = [
                'name'  =>  ucwords(strtolower($brand->brand)),
                'y'     =>  $brand->total
            ];
        }

        return $brand_statistics;
    }

    public function getMonthlyDownloads($year){
        $sql = "SELECT m.month, COUNT(a.id) as downloads
            FROM
            (
                      SELECT 1 AS MONTH
                       UNION SELECT 2 AS MONTH
                       UNION SELECT 3 AS MONTH
                       UNION SELECT 4 AS MONTH
                       UNION SELECT 5 AS MONTH
                       UNION SELECT 6 AS MONTH
                       UNION SELECT 7 AS MONTH
                       UNION SELECT 8 AS MONTH
                       UNION SELECT 9 AS MONTH
                       UNION SELECT 10 AS MONTH
                       UNION SELECT 11 AS MONTH
                       UNION SELECT 12 AS MONTH
            ) as m
            LEFT JOIN app_users a ON m.month = MONTH(a.created_at) AND YEAR(a.created_at) = {$year}
            GROUP BY m.month";
        $downloads = \DB::select(\DB::raw($sql));
        $cleaned_data = [];
        foreach ($downloads as $download) {
            $cleaned_data[] = [
                'month'     =>  date('M', strtotime($year . "/" . $download->month . "/01")),
                'download'  =>  $download->downloads
            ];
        }

        return $cleaned_data;
    }

    public function getAndroidVersionDistribution(){
        $versions = AppUser::select('android_release', \DB::raw('count(*) as total'))->groupBy('android_release')->get();

        return $versions;
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
