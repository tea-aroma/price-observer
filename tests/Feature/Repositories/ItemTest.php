<?php

namespace Tests\Feature\Repositories;

use App\Data\Items\ItemDataAttributes;
use App\Models\Item;
use App\Repositories\ItemRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = ItemDataAttributes::fromArray(Item::factory()->raw([ 'platform_id' => 2 ]));

        ItemRepository::query()->write($attributes);

        $this->assertDatabaseHas('items', [
            'platform_id' => $attributes->platform_id,
        ]);
    }

    public function test_update(): void
    {
        $attributes = ItemDataAttributes::fromArray(Item::factory()->raw([ 'platform_id' => 2 ]));

        $record = ItemRepository::query()->write($attributes);

        $attributes->id = $record->id;

        $attributes->platform_id = 5;

        ItemRepository::query()->update($attributes);

        $this->assertDatabaseHas('items', [
            'platform_id' => 5,
        ]);
    }
}
