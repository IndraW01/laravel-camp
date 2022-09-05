<?php

namespace Database\Seeders;

use App\Models\CampBenefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Pro Techstack Kit'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'iMac Pro 2021 & Display'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => '1-1 Mentoring Program'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Final Project Certificate'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Offline Course Videos'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Future Job Opportinity'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Premium Design Kit'
        ]);
        CampBenefit::create([
            'camp_id' => 1,
            'name' => 'Website Builder'
        ]);

        CampBenefit::create([
            'camp_id' => 2,
            'name' => '1-1 Mentoring Program'
        ]);
        CampBenefit::create([
            'camp_id' => 2,
            'name' => 'Final Project Certificate'
        ]);
        CampBenefit::create([
            'camp_id' => 2,
            'name' => 'Offline Course Videos'
        ]);
        CampBenefit::create([
            'camp_id' => 2,
            'name' => 'Future Job Opportinity'
        ]);
    }
}
