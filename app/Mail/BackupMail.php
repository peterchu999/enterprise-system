<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $files,$time;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($files,$time)
    {
        $this->files = $files;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('backup@wirasukses.com')
                   ->view('mail_template')
                   ->with(
                    [
                        'nama' => 'Winston Agus',
                        'website' => 'wirasukses.com',
                        'time' => $this->time
                    ])->attach($this->files);
    }
}
