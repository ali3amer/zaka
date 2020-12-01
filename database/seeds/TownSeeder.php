<?php

use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $towns = ['دنقلا' , 'مروي', 'الدبه', 'القولد', 'حلفا', 'البرقيق', 'دلقو'];

        foreach ($towns as $town) {
            \App\Town::create([
                'name' => $town,
                'state_id' => 1
            ]);
        }
    }
}
