<?php

namespace Tests\Feature\Services;

use App\Data\Items\ItemData;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\Recipients\RecipientData;
use App\Mail\RecipientEmailConfirmMail;
use App\Mail\RecipientNotifyMail;
use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\ItemInformation;
use App\Models\Recipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailerTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmation_sent(): void
    {
        Mail::fake();

        $recipient = Recipient::factory()->create();

        Mail::to('test@example.com')->send(new RecipientEmailConfirmMail(RecipientData::fromArray($recipient->toArray())));

        Mail::assertSent(RecipientEmailConfirmMail::class, function ($mail) {
            return $mail->hasTo('test@example.com');
        });
    }

    public function test_notify_sent(): void
    {
        Mail::fake();

        $item = Item::factory()->create();

        $itemData = ItemData::fromArray($item->toArray());

        $itemInformation = ItemInformation::factory()->create([ 'item_id' => $item->id]);

        $itemHistory = ItemHistory::factory()->create([ 'item_id' => $item->id ]);

        $itemHistoryData = ItemHistoryData::fromArray($itemHistory->toArray());

        $recipient = Recipient::factory()->create();

        $recipientData = RecipientData::fromArray($recipient->toArray());

        Mail::to('test@example.com')->send(new RecipientNotifyMail($itemData, $itemHistoryData, $recipientData));

        Mail::assertSent(RecipientNotifyMail::class, function ($mail) {
            return $mail->hasTo('test@example.com');
        });
    }
}
