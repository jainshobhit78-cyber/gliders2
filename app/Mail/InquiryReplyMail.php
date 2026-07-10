<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replySubject;
    public $replyBody;
    public $originalMessage;

    public function __construct($replySubject, $replyBody, ContactMessage $originalMessage)
    {
        $this->replySubject = $replySubject;
        $this->replyBody = $replyBody;
        $this->originalMessage = $originalMessage;
    }

    public function build()
    {
        return $this->subject($this->replySubject)
                    ->view('emails.inquiry_reply');
    }
}
