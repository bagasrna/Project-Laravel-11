<?php

namespace Database\Seeders;

use App\Domain\Customer\Customer;
use App\Enums\CustomerRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Customer::truncate();

        $admin = Customer::create([
            'name' => 'Bagas Raditya Nafi',
            'email' => 'bagas@gmail.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole(CustomerRole::CUSTOMER);

        Schema::enableForeignKeyConstraints();
    }
}
