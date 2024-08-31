<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @return void
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Password Has Been Changed!')
                    ->view('emails.password_changed')
                    ->with([
                        'userName' => $this->userName,
                    ]);
    }
}
