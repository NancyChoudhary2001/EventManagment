<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\otpemail;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Queueable , Dispatchable, InteractsWithQueue, SerializesModels;

    protected $user;
    protected $otp;

    public function __construct($user,$otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new otpemail($this->otp));
    }
}
