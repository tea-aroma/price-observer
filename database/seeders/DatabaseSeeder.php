<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        cache()->flush();

        $this->call(SettingSeeder::class);

        $this->call(CurrencySeeder::class);

        $this->call(ItemDelaySeeder::class);

        $this->call(ItemStatusSeeder::class);
    }

    /**
     * Creates records by the specified arguments.
     *
     * @param array $records
     * @param Model $model
     *
     * @return void
     */
    public static function createRecords(array $records, Model $model): void
    {
        foreach ($records as $record)
        {
            $model->newQuery()->create($record);
        }
    }
}
