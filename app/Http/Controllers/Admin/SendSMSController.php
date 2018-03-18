<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HCWWorkers as Workers;
use App\SMSLog;
use App\Jobs\SendHCWSMS;

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

    public function testHCW(Request $request){
        $workers = [
            [
                'hcw_name'      =>  'Chrispine Otaalo',
                'county'        =>  'Kakamega',
                'mobile_number' =>  '254725160399'
            ],
            [
                'hcw_name'      =>  'Chrispine Otaalo',
                'county'        =>  'Migori',
                'mobile_number' =>  '254708331808'
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
