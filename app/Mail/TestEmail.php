<?php


namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class TestEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $surname;
    public $password;
    public function __construct($name, $surname, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Účet vytvořen',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-created',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
