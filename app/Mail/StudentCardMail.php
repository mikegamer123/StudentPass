<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentCardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public function __construct($nameTo)
    {
        $this->name = $nameTo;
    }

    public function build()
    {

        return $this->view('newCardMail')
            ->subject('Kartica za '.$this->name.'!')
            ->from('mihalozigalo@gmail.com', 'Student-Pass');
    }
}
