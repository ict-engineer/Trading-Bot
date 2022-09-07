<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prophecy\Exception\Prediction\AggregateException;
use App\Models\Contact_Us;

class Contacto extends Mailable
{
    use Queueable, SerializesModels;
    public $contact_us;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact_Us $contact_us)
    {
        //
        $this->contact_us     = $contact_us;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() 
    {
        return $this->view('user.mails.index');
    }
}
