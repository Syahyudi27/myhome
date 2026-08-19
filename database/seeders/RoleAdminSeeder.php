<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $lenderRole = Role::create([
            'name' => 'lender'
        ]);

        $agentRole = Role::create([
            'name' => 'agent'
        ]);

        $customerRole = Role::create([
            'name' => 'customer'
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '082120202025',
            'photo' => 'angga.png',
            'password' => bcrypt('123456789')
        ]);

        $user->assignRole($adminRole);
    }
}
