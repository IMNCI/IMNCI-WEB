<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\SMSLog;

use GuzzleHttp\Client;

class SendHCWSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $worker;
    public function __construct($worker)
    {
        $this->worker= $worker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try{
            $username="tngugi@clintonhealthaccess.org";
            $password="9LeJ?K?_Z5=7_y%eJ8nB_pD3&A=gUWfLAG2C";

            $num = $this->worker->mobile_number;

            $msg="The 2018 Edition of the IMNCI Guidelines Android app is available for download from Google Play Store for FREE.  \n
    Click this link to download https://play.google.com/store/apps/details?id=org.ministryofhealth.newimci&hl=en .  \n
    Ministry of Health - NCAHU";

            $senderid="20027";

            $message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);

            $URL="http://sms.southwell.io/api/v1/messages";

            $client = new Client();

            $response = $client->request('POST', $URL, [
                'auth'  =>  [
                    $username, $password
                ],
                'json'  =>  $message
            ]);

            date_default_timezone_set('Africa/Nairobi');
            $datesent = date('Y-m-d H:i:s');
            $smslog = new SMSLog();

            $smslog->phonenumber = $this->worker->mobile_number;
            $smslog->name = $this->worker->hcw_name;
            $smslog->time_sent = $datesent;

            if ($response->getStatusCode() =='201') //success
            {
                $smslog->status = 1;
            }       
            else
            {
                $smslog->status = 0;
            }

            $smslog->save();
        }catch(Exception $ex){
            report($ex);
        }
    }
}
