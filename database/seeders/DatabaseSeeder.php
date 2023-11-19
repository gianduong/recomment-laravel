<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        for ($i = 0; $i < 1000; $i++) {
            DB::table('diem_so')->insert([
                'diemTB' => rand(4, 9) + rand(0, 10) / 10,
                'diemthiDH' => rand(4, 9) + rand(0, 10) / 10,
            ]);
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
