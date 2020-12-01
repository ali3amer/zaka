<?php

use Illuminate\Database\Seeder;

class DelegateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delegates = ['عبدالقادر مسي', 'انور عبدالرحمن', 'عبدالقادر الحداد'];

        $i = 1;

        foreach ($delegates as $delegate) {
            \App\Delegate::create([
                'name' => $delegate,
                'phone' => '0912300011'
            ])->zones()->sync([$i => ['user_id' => 1]]);

            $i++;
        }

    }
}
