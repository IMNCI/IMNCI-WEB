<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HCWWorkers as Workers;
use App\SMSLog;
use App\Jobs\SendHCWSMS;

use GuzzleHttp\Client;

class SendSMSController extends Controller
{
    public function allHCW(Request $request){
        $workers = Workers::all();

        foreach($workers as $worker){
            dispatch(new SendHCWSMS($worker));
        }

        $request->session()->flash('success', 'Your messages are on their way to ' . count($workers) . ' HCW Workers');
        return redirect()->route('hcw-workers');
    }

    public function test(){
        $url = "http://sms.southwell.io/api/v1/messages";

        $username="tngugi@clintonhealthaccess.org";
        $password="9LeJ?K?_Z5=7_y%eJ8nB_pD3&A=gUWfLAG2C";

        $num = '254725160399';
        $msg = "The 2017 Edition of the IMNCI Guidelines is available for download from Google Play Store for FREE.  \n
    Click this link to download https://play.google.com/store/apps/details?id=org.ministryofhealth.newimci&hl=en .  \n
    Ministry of Health - NCAHU";
    $senderid="20027";

        $message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);
        $sms = json_encode($message);

        $client = new Client();

        $response = $client->request('POST', $url, [
            'auth'  =>  [
                $username, $password
            ],
            'json'  =>  $message
        ]);

        echo "<pre>";print_r($response->getBody());die;
    }

    public function testHCW(Request $request){
        $workers = [
            [
                'hcw_name'      =>  'Chrispine Otaalo',
                'county'        =>  'Kakamega',
                'mobile_number' =>  '254725160399'
            ],
            [
                'hcw_name'      =>  'Sheila Mutheu',
                'county'        =>  'Nairobi',
                'mobile_number' =>  '254726416795'
            ]
        ];

        foreach($workers as $worker){
            $worker = (object) $worker;
            // $worker = new Workers();

            // $worker->hcw_name = $w['hcw_name'];
            // $worker->county = $w['county'];
            // $worker->mobile_number = $w['mobile_number'];

            dispatch(new SendHCWSMS($worker));
        }

        $request->session()->flash('success', 'Your messages are on their way to ' . count($workers) . ' test accounts');
        return redirect()->route('hcw-workers');
    }
    
    public function logs(){
        $data['logs'] = SMSLog::all();
        return view('dashboard/sendsms/index')->with($data);
    }
}
