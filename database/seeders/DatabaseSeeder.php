<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\Admin::create([
        //     'username' => 'Admins',
        //     'password' => Hash::make('Admins123'),
        // ]);
        $this->call([
            SchedulesTableSeeder::class,
            MerchandisersTableSeeder::class,
            // Add more seeders as needed
        ]);
    }
}
