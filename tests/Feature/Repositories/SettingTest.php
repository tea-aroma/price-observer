<?php

namespace Feature\Repositories;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_by_value(): void
    {
        Setting::factory()->create([ 'key' => 'app_name' ]);

        $this->assertDatabaseHas('settings', [ 'key' => 'app_name' ]);
    }
}
