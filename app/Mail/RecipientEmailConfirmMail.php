<?php

namespace App\Mail;

use App\Data\Recipients\RecipientData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


/**
 *
 */
class RecipientEmailConfirmMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var RecipientData
     */
    public RecipientData $recipient;

    /**
     * @var string
     */
    public string $link;

    /**
     * Create a new message instance.
     */
    public function __construct(RecipientData $recipient)
    {
        $this->recipient = $recipient;

        $this->link = route('recipient.confirm', [ 'token' => $this->recipient->token ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.recipient-confirm',
            with: [ 'link' => $this->link ],
        );
    }
}
