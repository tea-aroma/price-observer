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
            [ 'key' => 'request_timeout', 'value' => '10', 'description' => 'Request timeout (seconds).' ],
            [ 'key' => 'request_user_agent', 'value' => 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.105 Mobile Safari/537.36', 'description' => '' ],
        ];
    }
}
