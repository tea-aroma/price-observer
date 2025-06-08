<?php

namespace Feature\Repositories;

use App\Data\ItemDelays\ItemDelayDataAttributes;
use App\Models\ItemDelay;
use App\Repositories\ItemDelayRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDelayTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = ItemDelayDataAttributes::fromArray([]);

        $values = ItemDelayDataAttributes::fromArray(ItemDelay::factory()->raw([ 'delay' => 20 ]));

        ItemDelayRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('item_delays', [
            'delay' => $values->delay,
        ]);
    }

    public function test_update(): void
    {
        $attributes = ItemDelayDataAttributes::fromArray([]);

        $values = ItemDelayDataAttributes::fromArray(ItemDelay::factory()->raw([ 'delay' => 20 ]));

        $record = ItemDelayRepository::query()->writeOrUpdate($attributes, $values);

        $attributes->id = $record->id;

        $values->delay = 25;

        ItemDelayRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('item_delays', [
            'delay' => $values->delay,
        ]);
    }
}
