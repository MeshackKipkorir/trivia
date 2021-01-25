<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $faker = Faker::create();

        foreach (range(1,20) as $index){
            DB::table('players')->insert([
                'name' => $faker->name,
                'answers' => $faker->randomNumber(),
                'points' => $faker -> randomNumber(),
                'created_at' => $faker -> date(),
                'updated_at' => $faker -> date()
            ]);
        }
    }
}
