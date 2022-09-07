<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;
    public $mail;
    public $sender;
    public $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        // dd($message);
        $this->sender       = env('MAIL_USERNAME');  
        $this->title        = "Reservation Support";
        $this->mail         = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mails.contact');
    }
}
