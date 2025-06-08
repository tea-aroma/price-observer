<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => Site::factory()->create()->id,
            'platform_id' => $this->faker->numberBetween(100, 200),
            'seller_id' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text,
        ];
    }
}
