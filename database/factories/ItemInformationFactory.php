<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemInformation>
 */
class ItemInformationFactory extends Factory
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
            'name' => $this->faker->name,
            'url' => $this->faker->url,
            'image' => $this->faker->imageUrl(),
            'note' => $this->faker->text,
            'parameters' => [ 'text' => $this->faker->text ],
            'publicate_at' => $this->faker->date,
        ];
    }
}
