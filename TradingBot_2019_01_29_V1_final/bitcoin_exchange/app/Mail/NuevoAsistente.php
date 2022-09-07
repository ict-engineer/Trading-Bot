<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Offers;

class NuevoAsistente extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $offer, $phone_number, $inscribed;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Offers $offer, $phone_number, $inscribed)
    {
        //
        $this->user = $user;
        $this->offer = $offer;
        $this->phone_number  = $phone_number;
        $this->inscribed     = $inscribed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mails.userofferRegister');
    }
}
