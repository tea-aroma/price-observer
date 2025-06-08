<?php

namespace App\Jobs;

use App\Data\Items\ItemData;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\Recipients\RecipientData;
use App\Repositories\ItemRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;


/**
 *
 */
class RecipientsNotifyJob implements ShouldQueue
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
     * Create a new job instance.
     */
    public function __construct(ItemData $item, ItemHistoryData $itemHistory)
    {
        $this->item = $item;

        $this->itemHistory = $itemHistory;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $item = ItemRepository::query()->find($this->item->id);

        $recipients = $item->recipients()->get();

        foreach ($recipients as $index => $recipient)
        {
            if (!$recipient->is_active)
            {
                continue;
            }

            RecipientNotifyJob::dispatch(ItemData::fromArray($item->toArray()), $this->itemHistory, RecipientData::fromArray($recipient->toArray()))->delay($index * 5);
        }
    }
}
