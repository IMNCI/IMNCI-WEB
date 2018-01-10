<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\IssueMailer;
use App\Mail\IssueConfirmation;

class SendIssueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $issue;
    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new IssueMailer($this->issue);
        $confirmer = new IssueConfirmation($this->issue);

        Mail::to(env('DEFAULT_SUPPORT_EMAIL', 'c.otaalo@gmail.com'))->send($email);
        Mail::to($this->issue->email)->send($confirmer);
    }
}
