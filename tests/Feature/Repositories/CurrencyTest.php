<?php

namespace Feature\Repositories;

use App\Data\Currencies\CurrencyDataAttributes;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = CurrencyDataAttributes::fromArray([]);

        $values = CurrencyDataAttributes::fromArray(Currency::factory()->raw([ 'code' => 'dollar' ]));

        CurrencyRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('currencies', [
            'code' => $values->code,
        ]);
    }

    public function test_update(): void
    {
        $attributes = CurrencyDataAttributes::fromArray([]);

        $values = CurrencyDataAttributes::fromArray(Currency::factory()->raw([ 'code' => 'dollar' ]));

        $record = CurrencyRepository::query()->writeOrUpdate($attributes, $values);

        $attributes->id = $record->id;

        $values->code = 'euro';

        CurrencyRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('currencies', [
            'code' => $values->code,
        ]);
    }
}
