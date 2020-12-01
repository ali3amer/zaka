<?php

use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [401, 402, 403, 404, 405];
        $start = 2352701;
        $end = $start + 49;

        foreach ($books as $book) {
            \App\Book::create([
                'number'    =>  $book,
                'start'     =>  $start,
                'end'       =>  $end,
                'user_id'   =>  1
            ]);

            $start = $end + 1;
            $end = $start + 49;

        }

    }
}
