<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new Setting());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'key' => 'recipient_confirmation_time', 'value' => 'deleted', 'description' => 'Duration time for email confirmation (seconds).' ],
        ];
    }
}
