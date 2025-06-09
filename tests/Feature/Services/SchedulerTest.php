<?php

namespace Tests\Feature\Services;

use App\Data\Items\ItemData;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\Recipients\RecipientData;
use App\Jobs\ItemCheckJob;
use App\Jobs\RecipientNotifyJob;
use App\Jobs\RecipientsNotifyJob;
use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\Recipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SchedulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_check(): void
    {
        Queue::fake();

        $item = Item::factory()->create();

        ItemCheckJob::dispatch($item);

        Queue::assertPushed(ItemCheckJob::class, function ($job) use ($item)
        {
            return $job->item->id === $item->id;
        });
    }

    public function test_recipient_notify(): void
    {
        Queue::fake();

        $item = Item::factory()->create();

        $itemData = ItemData::fromArray($item->toArray());

        $itemHistory = ItemHistory::factory()->create([ 'item_id' => $item->id ]);

        $itemHistoryData = ItemHistoryData::fromArray($itemHistory->toArray());

        $recipient = Recipient::factory()->create();

        $recipientData = RecipientData::fromArray($recipient->toArray());

        RecipientNotifyJob::dispatch($itemData, $itemHistoryData, $recipientData);

        Queue::assertPushed(RecipientNotifyJob::class, function ($job) use ($itemData, $itemHistoryData, $recipientData)
        {
            return $job->item->id === $itemData->id && $job->itemHistory->id === $itemHistoryData->id && $job->recipient->id === $recipientData->id;
        });
    }

    public function test_recipients_notify(): void
    {
        Queue::fake();

        $item = Item::factory()->create();

        $itemData = ItemData::fromArray($item->toArray());

        $itemHistory = ItemHistory::factory()->create([ 'item_id' => $item->id ]);

        $itemHistoryData = ItemHistoryData::fromArray($itemHistory->toArray());

        RecipientsNotifyJob::dispatch($itemData, $itemHistoryData);

        Queue::assertPushed(RecipientsNotifyJob::class, function ($job) use ($itemData, $itemHistoryData)
        {
            return $job->item->id === $itemData->id && $job->itemHistory->id === $itemHistoryData->id;
        });
    }
}
