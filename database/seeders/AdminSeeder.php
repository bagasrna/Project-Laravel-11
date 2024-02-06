<?php

namespace Database\Seeders;

use App\Domain\Admin\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Contracts\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Admin::truncate();
        
        $admin = Admin::create([
            'name' => 'Muhammad Ibnu',
            'email' => 'ibnu@gmail.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('Admin');

        Schema::enableForeignKeyConstraints();
    }
}
