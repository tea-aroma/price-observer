<?php

namespace Database\Seeders;

use App\Models\ItemStatus;
use Illuminate\Database\Seeder;

class ItemStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new ItemStatus());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'name' => 'Unknown', 'code' => 'unknown' ],
            [ 'name' => 'Deleted', 'code' => 'deleted' ],
            [ 'name' => 'Inactive', 'code' => 'inactive' ],
        ];
    }
}
