<?php


namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class EventEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $description;
    public $start;
    public $end;
    public function __construct($title, $description, $start, $end)
    {
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nová akce',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-created',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
