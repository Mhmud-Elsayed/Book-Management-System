<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $author;

    /**
     * Create a new message instance.
     */
    public function __construct($author)
    {
        $this->author = $author;
    }

    public function build()
    {
        return $this->subject('Welcome to our system')
            ->view('emails.AuthorWelcomeEmail', ['author' => $this->author]);
    }
}
