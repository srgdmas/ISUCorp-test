<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $metadata;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $metadata
     */
    public function __construct($data, $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recuperar contraseña para su cuenta en ISU Corp')->view('mail.recoverPassword');
    }
}
