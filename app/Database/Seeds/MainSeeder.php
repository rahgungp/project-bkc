<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('RolesSeeder');
        $this->call('UsersSeeder');
        $this->call('CompanyProfileSeeder');
        $this->call('FounderProfileSeeder');
        $this->call('TrainingCategoriesSeeder');
        $this->call('LocationsSeeder');
        $this->call('SpeakersSeeder');
        $this->call('FaqsSeeder');
    }
}
