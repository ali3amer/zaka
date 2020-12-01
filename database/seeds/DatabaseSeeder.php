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
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(TownSeeder::class);
        $this->call(OfficeSeeder::class);
        $this->call(ZoneSeeder::class);
        $this->call(DelegateSeeder::class);
        $this->call(CropSeeder::class);
        $this->call(BookSeeder::class);
    }
}
