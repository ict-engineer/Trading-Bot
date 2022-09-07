<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendMailVerify extends Mailable
{
    use Queueable, SerializesModels;
    public $url, $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $username)
    {
        //
        // dd($url);
        $this->url       = $url;
        $this->username  = $username;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->message);
        return $this->view('user.mails.emailverify');
    }
}
