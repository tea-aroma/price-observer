<?php

namespace App\Mail;

use App\Data\Items\ItemData;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\Recipients\RecipientData;
use App\Models\ItemInformation;
use App\Repositories\ItemInformationRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


/**
 *
 */
class RecipientNotifyMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var ItemData
     */
    public ItemData $item;

    /**
     * @var ItemHistoryData
     */
    public ItemHistoryData $itemHistory;

    /**
     * @var RecipientData
     */
    public RecipientData $recipient;

    /**
     * @var ItemInformation
     */
    public ItemInformation $itemInformation;

    /**
     * Create a new message instance.
     */
    public function __construct(ItemData $item, ItemHistoryData $itemHistory, RecipientData $recipient)
    {
        $this->item = $item;

        $this->itemHistory = $itemHistory;

        $this->recipient = $recipient;

        $this->itemInformation = ItemInformationRepository::query()->findByValue($item->id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'The price has changed!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.recipient-notify',
        );
    }
}
