<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $param;
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->param['blade']=='auth')
            return $this->subject($this->param['subject'])->view('mails.auth-mail');
        elseif($this->param['blade'] == 'reset')
            return $this->subject($this->param['subject'])->view('mails.reset-mail');
    }
}
