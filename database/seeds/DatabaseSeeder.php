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
        $this->call(ItemsSeeder::class);
        $this->call(LaratrustSeeder::class);
        #$this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PriceCategoryListSeeder::class);
        $this->call(PriceCustomerListSeeder::class);
        $this->call(PriceItemsListSeeder::class);
        $this->call(CustomerSeeder::class);

    }
}
