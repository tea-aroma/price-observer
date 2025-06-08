<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemHistory>
 */
class ItemHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory()->create()->id,
            'old_price' => $this->faker->numberBetween(100, 200),
            'new_price' => $this->faker->numberBetween(100, 200),
            'old_price_text' => $this->faker->text,
            'new_price_text' => $this->faker->text,
        ];
    }
}
