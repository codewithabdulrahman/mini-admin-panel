<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use App\Models\Company;
use App\Models\Employee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::factory(5)->create();
        Employee::factory(5)->create();
        $this->call(UserSeeder::class);
    }
}
