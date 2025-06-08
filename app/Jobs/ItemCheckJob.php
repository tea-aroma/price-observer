<?php

namespace App\Jobs;

use App\Data\ItemsHistory\ItemHistoryData;
use App\Models\Item;
use App\Repositories\ItemHistoryRepository;
use App\Standards\Parsers\Classes\HtmlParser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;


/**
 *
 */
class ItemCheckJob implements ShouldQueue
{
    use Queueable, Dispatchable;


    /**
     * @var Item
     */
    protected Item $item;

    /**
     * Create a new job instance.
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $item = (new \App\Standards\Items\Item())->update(new HtmlParser($this->item->information->url));

        $history = ItemHistoryData::fromArray(ItemHistoryRepository::query()->latestByItemId($item->id)->toArray());

        if ($history->old_price !== $history->new_price)
        {
            RecipientsNotifyJob::dispatch($item, $history)->delay(10);
        }
    }
}
