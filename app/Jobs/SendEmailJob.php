<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\passwordemail;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $user;
    protected $password;
    protected $fullname;
    public function __construct($user, $password, $fullname)
    {
        $this->user = $user;
        $this->password = $password;
        $this->fullname = $fullname;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new passwordemail($this->user, $this->password, $this->fullname));
    }
}
