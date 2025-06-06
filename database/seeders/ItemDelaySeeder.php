<?php

namespace Database\Seeders;

use App\Models\ItemDelay;
use Illuminate\Database\Seeder;

class ItemDelaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new ItemDelay());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'name' => 'Normal', 'code' => 'normal', 'value' => 25 ],
            [ 'name' => 'Timeout', 'code' => 'timeout', 'value' => 15 ],
            [ 'name' => 'Error', 'code' => 'error', 'value' => 30 ],
        ];
    }
}
