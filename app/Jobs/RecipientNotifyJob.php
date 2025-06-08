<?php

namespace App\Jobs;

use App\Data\Items\ItemData;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\Recipients\RecipientData;
use App\Mail\RecipientNotifyMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;


/**
 *
 */
class RecipientNotifyJob implements ShouldQueue
{
    use Queueable, Dispatchable;

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
     * Create a new job instance.
     */
    public function __construct(ItemData $item, ItemHistoryData $itemHistory, RecipientData $recipient)
    {
        $this->item = $item;

        $this->itemHistory = $itemHistory;

        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recipient->email)->queue(new RecipientNotifyMail($this->item, $this->itemHistory, $this->recipient));
    }
}
