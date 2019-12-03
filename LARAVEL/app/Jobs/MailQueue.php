<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lang;

class MailQueue extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $mailInfo;

    public function __construct($mailInfo)
    {
        $this->mailInfo = $mailInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->from(env("MAIL_USERNAME"))
            ->subject($this->mailInfo['subject'])
            ->view('email.email', ['mailInfo'=>$this->mailInfo]);
    }
}
