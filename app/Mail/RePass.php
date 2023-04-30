<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RePass extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }
    public function build()
    {
        return $this->subject('Заявка с Bagala Meni')
            ->markdown('emails.rePass');
    }
}
