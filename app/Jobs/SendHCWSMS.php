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

            $msg="The 2017 Edition of the IMNCI Guidelines is available for download from Google Play Store for FREE.  \n
    Click this link to download https://play.google.com/store/apps/details?id=org.ministryofhealth.newimci&hl=en .  \n
    Ministry of Health - NCAHU";

            $senderid="20027";

            $message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);

            $URL="http://sms.southwell.io/api/v1/messages";
            $sms = json_encode($message);

            // $httpRequest = curl_init($URL);
            // curl_setopt($httpRequest, CURLOPT_NOBODY, true);
            // curl_setopt($httpRequest, CURLOPT_POST, true);
            // curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $sms);
            // curl_setopt($httpRequest, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            // curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER,1);
            // curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($sms)));
            // curl_setopt($httpRequest, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            // curl_setopt($httpRequest, CURLOPT_USERPWD, "$username:$password");
            // $results=curl_exec ($httpRequest);
            // $status_code = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE); //get status code
            // curl_close ($httpRequest);
            // $response = json_decode($results);
            // echo $status_code;

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
            //echo $response->message;
            if ($response->getStatusCode() =='201') //success
            {
                $smslog->status = 1;

            //$d=mysql_query("update viralsamples set patientsmssent=1, patientsmsdatesent='$datesent'  where ID='$ID'");
            }       
            else
            {
                $smslog->status = 0;
                // report("There was an error sending SMS to {$num}");
                //  throw new Exception("sms not successful");  
            }

            $smslog->save();
        }catch(Exception $ex){
            report($ex);
        }
    }
}
