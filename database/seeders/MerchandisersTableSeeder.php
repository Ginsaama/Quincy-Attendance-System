<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Merchandiser;
use Illuminate\Support\Facades\Hash;

class MerchandisersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            Merchandiser::create([
                'call_sign' => "User $i",
                'name' => "Mcdo $i",
                'status' => '1',
            ]);
        }
    }
}
