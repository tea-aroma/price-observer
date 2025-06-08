<?php

namespace Feature\Repositories;

use App\Data\Recipients\RecipientDataAttributes;
use App\Models\Recipient;
use App\Repositories\RecipientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipientTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = RecipientDataAttributes::fromArray(Recipient::factory()->raw([ 'name' => 'Recipient' ]));

        $record = RecipientRepository::query()->write($attributes);

        $this->assertDatabaseHas('recipients', [
            'name' => $attributes->name,
        ]);
    }

    public function test_update(): void
    {
        $attributes = RecipientDataAttributes::fromArray(Recipient::factory()->raw([ 'name' => 'Recipient' ]));

        $record = RecipientRepository::query()->write($attributes);

        $attributes->id = $record->id;

        $attributes->name = 'New Recipient';

        RecipientRepository::query()->update($attributes);

        $this->assertDatabaseHas('recipients', [
            'name' => $attributes->name,
        ]);
    }
}
