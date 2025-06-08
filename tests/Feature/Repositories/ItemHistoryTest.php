<?php

namespace Feature\Repositories;

use App\Data\ItemsHistory\ItemHistoryDataAttributes;
use App\Models\ItemHistory;
use App\Repositories\ItemHistoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = ItemHistoryDataAttributes::fromArray([]);

        $values = ItemHistoryDataAttributes::fromArray(ItemHistory::factory()->raw([ 'new_price' => 100 ]));

        ItemHistoryRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('items_history', [
            'new_price' => $values->new_price,
        ]);
    }

    public function test_update(): void
    {
        $attributes = ItemHistoryDataAttributes::fromArray([]);

        $values = ItemHistoryDataAttributes::fromArray(ItemHistory::factory()->raw([ 'new_price' => 100 ]));

        $record = ItemHistoryRepository::query()->writeOrUpdate($attributes, $values);

        $attributes->id = $record->id;

        $values->new_price = 250;

        ItemHistoryRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('items_history', [
            'new_price' => $values->new_price,
        ]);
    }
}
