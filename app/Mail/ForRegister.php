<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->data['mailling']['current']['subject'])
            ->view($this->data['mailling']['current']['template'])->with(['global_data' => $this->data]);
    }
}
