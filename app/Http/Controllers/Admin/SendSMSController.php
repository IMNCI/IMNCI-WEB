<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HCWWorkers as Workers;
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
}
