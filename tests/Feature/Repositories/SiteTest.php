<?php

namespace Feature\Repositories;

use App\Data\Sites\SiteDataAttributes;
use App\Models\Site;
use App\Repositories\SiteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_write(): void
    {
        $attributes = SiteDataAttributes::fromArray([]);

        $values = SiteDataAttributes::fromArray(Site::factory()->raw([ 'url' => 'http://site.com' ]));

        SiteRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('sites', [
            'url' => $values->url,
        ]);
    }

    public function test_update(): void
    {
        $attributes = SiteDataAttributes::fromArray([]);

        $values = SiteDataAttributes::fromArray(Site::factory()->raw([ 'url' => 'http://site.com' ]));

        $record = SiteRepository::query()->writeOrUpdate($attributes, $values);

        $attributes->id = $record->id;

        $values->url = 'http://site.com/index';

        SiteRepository::query()->writeOrUpdate($attributes, $values);

        $this->assertDatabaseHas('sites', [
            'url' => $values->url,
        ]);
    }
}
