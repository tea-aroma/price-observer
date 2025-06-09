<?php

namespace Tests\Feature\Services;

use App\Models\Recipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipientTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmation(): void
    {
        $recipient = Recipient::factory()->create([ 'is_active' => false ]);

        $this->assertDatabaseHas('recipients', [
            'is_active' => false,
        ]);

        \recipient()->confirm($recipient->token);

        $this->assertDatabaseHas('recipients', [
            'is_active' => true,
        ]);
    }
}
