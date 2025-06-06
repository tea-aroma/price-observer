<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new Currency());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'code' => 'UNKNOWN', 'name' => 'UNKNOWN', 'symbol' => '-' ],
            [ 'code' => 'UAH', 'name' => 'Гривна', 'symbol' => '₴' ],
            [ 'code' => 'USD', 'name' => 'Dollar', 'symbol' => '$' ],
            [ 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€' ],
        ];
    }
}
