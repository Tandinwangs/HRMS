<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $startDate;
    public $endDate;
    public $currentUser;

    public function __construct($user, $startDate, $endDate, $currentUser)
    {
        $this->user = $user;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->currentUser = $currentUser;
    }

    public function build()
    {
        return $this->markdown('emails.leave-application')
            ->subject('Leave Application Submitted');
    }
}

