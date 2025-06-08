<?php

namespace Feature\Repositories;

use App\Data\ItemsInformation\ItemInformationDataAttributes;
use App\Models\ItemInformation;
use App\Repositories\ItemInformationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = ItemInformationDataAttributes::fromArray([]);

        $values = ItemInformationDataAttributes::fromArray(ItemInformation::factory()->raw([ 'note' => 'some note' ]));

        ItemInformationRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('items_information', [
            'note' => 'some note',
        ]);
    }

    public function test_update(): void
    {
        $attributes = ItemInformationDataAttributes::fromArray([]);

        $values = ItemInformationDataAttributes::fromArray(ItemInformation::factory()->raw([ 'note' => 'some note' ]));

        $item = ItemInformationRepository::query()->writeOrUpdate($attributes, $values);

        $attributes->id = $item->id;

        $values->note = 'advanced some note';

        ItemInformationRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('items_information', [
            'note' => 'advanced some note',
        ]);
    }
}
