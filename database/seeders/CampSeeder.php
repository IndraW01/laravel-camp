<?php

namespace Database\Seeders;

use App\Models\Camp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Camp::create([
            'title' => 'Gila Belajar',
            'slug' => 'gila-belajar',
            'price' => 280
        ]);

        Camp::create([
            'title' => 'Baru Mulai',
            'slug' => 'baru-mulai',
            'price' => 140
        ]);
    }
}
