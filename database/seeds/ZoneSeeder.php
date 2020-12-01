<?php

use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zones = ['قسم 2 وسط', 'قسم 2 شرق الحوض', 'قسم 2 جنوب'];

        foreach ($zones as $zone) {
            \App\Zone::create([
                'name' => $zone,
                'office_id' => 1
            ]);
        }
    }
}
