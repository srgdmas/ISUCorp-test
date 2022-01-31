<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Login extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $metadata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $metadata)
    {
        $this->user = $user;
        $this->metadata = $metadata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Inicio de sesión en ISU Corp')->view('mail.login');
    }
}
