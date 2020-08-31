<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notification extends Mailable
{
    use Queueable, SerializesModels;

    //メール本文に使用する変数を定義
    public $destination;
    public $title;
    public $text;
    public $schedule;

    /**
     * Create a new message instance
     *
     * @param $destination
     * @param $title
     * @param $text
     * @param $schedule
     */
    public function __construct($destination,$title,$text,$schedule)
    {
        $this->destination = $destination;
        $this->title = $title;
        $this->text = $text;
        $this->schedule = $schedule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ekugio.0809@gmail.com')
                    ->view('mail.notification.information');
    }
}
