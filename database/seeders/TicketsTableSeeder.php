<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 13; $i++) {
            DB::table('tickets')->insert([
                'nama_ticket' => $faker->word,
                'harga_ticket' => $faker->randomNumber(5),
                'gambar' => $faker->imageUrl(640, 480, 'travel', true, 'Faker'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
