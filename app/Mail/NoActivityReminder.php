<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoActivityReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @param  string  $userName
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
        return $this->subject('We Miss You at ' . config('app.name') . '!')
                    ->view('emails.no_activity_reminder')
                    ->with([
                        'userName' => $this->userName,
                    ]);
    }
}
