<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $cbook = new Book();

            $cbook->isbn = $faker->randomNumber(8);
            $cbook->title = $faker->name;
            $cbook->year = rand(2010, 2021);

            $cbook->publisher_id = rand(1, 20);
            $cbook->author_id = rand(1, 20);
            $cbook->catalog_id = rand(1, 4);

            $cbook->qty = rand(10, 20);
            $cbook->price = rand(10000, 20000);

            $cbook->save();
        }
    }
}
