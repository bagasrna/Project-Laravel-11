<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionCustomerSeeder::class);
        $this->call(PermissionAdminSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
