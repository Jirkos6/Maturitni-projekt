<?php


namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $surname;
    public $password;
    public $email;
    public function __construct($name, $surname, $password, $email)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->email = $email;
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
