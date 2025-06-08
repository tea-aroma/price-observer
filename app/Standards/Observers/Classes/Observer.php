<?php

namespace App\Standards\Observers\Classes;


use App\Data\Items\ItemDataOptions;
use App\Jobs\ItemCheckJob;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Standards\Enums\SettingKey;
use Illuminate\Support\Collection;


/**
 * Provides the logic for the items Observing.
 */
class Observer
{
    /**
     * @return Collection<Item>
     */
    public function items(): Collection
    {
        $options = new ItemDataOptions([]);

        $options->is_active = true;

        return ItemRepository::query()->records($options);
    }

    /**
     * @return void
     */
    public function check(): void
    {
        $items = $this->items();

        foreach ($items as $index => $item)
        {
            ItemCheckJob::dispatch($item)->delay($index * ((int) SettingKey::ITEMS_CHECK_DELAY->data()->value));
        }
    }
}
