<?php

use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = ['دنقلا', 'شرق النيل', 'الحفير'];

        foreach ($offices as $office) {
            \App\Office::create([
                'name' => $office,
                'town_id' => 1
            ]);
        }
    }
}
