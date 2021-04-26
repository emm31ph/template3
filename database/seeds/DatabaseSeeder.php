<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CounterSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ItemsSeeder::class);
    }
}
