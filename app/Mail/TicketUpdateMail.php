<?php

namespace App\Mail;

use App\Models\ProblemLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProblemLog $problemLog;
    public string $mailTitle;
    public string $mailMessage;

    public function __construct(ProblemLog $problemLog, string $mailTitle, string $mailMessage)
    {
        $this->problemLog = $problemLog;
        $this->mailTitle = $mailTitle;
        $this->mailMessage = $mailMessage;
    }

    public function build()
    {
        return $this->subject($this->mailTitle)
            ->view('emails.ticket-update');
    }
}
