<?php

use Illuminate\Database\Seeder;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crops = ['فول', 'قمح'];

        foreach ($crops as $crop) {
            \App\Crop::create(['name' => $crop]);
        }
    }
}
