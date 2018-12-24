<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contactable extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $reply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reply)
    {
        //
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.mail')->with([
            'name' => $this->reply->name,
            'email' => $this->reply->email,
            'tel' => $this->reply->phone,
            'message' => $this->reply->content,
        ]);
    }
}
