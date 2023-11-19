<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DiemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $limit = 1000;
        for ($i = 0; $i < $limit; $i++) {
            DB::table('diem_so')->insert([
                'diemTB' => $faker->randomElement([7,6,5,8,9,6.5,7.5,8.5,9.5]),
                'diemthiDH' => $faker->randomElement([7,6,5,8,9,6.5,7.5,8.5,9.5]),
            ]);
        }
    }
}
