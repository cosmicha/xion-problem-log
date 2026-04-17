<?php

namespace App\Mail;

use App\Models\ProblemLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProblemLog $problemLog;
    public string $eventTitle;
    public string $eventMessage;

    public function __construct(ProblemLog $problemLog, string $eventTitle, string $eventMessage)
    {
        $this->problemLog = $problemLog;
        $this->eventTitle = $eventTitle;
        $this->eventMessage = $eventMessage;
    }

    public function build()
    {
        return $this->subject($this->eventTitle . ' - ' . ($this->problemLog->ticket_number ?: 'Ticket'))
            ->view('emails.ticket-event');
    }
}
