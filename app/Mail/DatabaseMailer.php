<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DatabaseMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $extras;
    public function __construct($extras)
    {
        $this->extras = $extras;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try{
            $email = $this
                        ->subject('IMCI Database ' . strtotime('d/m/Y H:i'))
                        ->view('email.backup');
            $email->attach($this->extras);
            return $email;
        }catch(\Exception $e){
            dd($e);
        }
    }
}
