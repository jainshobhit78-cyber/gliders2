<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@gliders.com'],
            [
                'name' => 'Administrator',
                'password' => 'Password@1234', // Will be hashed automatically by $casts in Admin model
            ]
        );

        $admin->assignRole('admin');
        
        echo "Admin User Created/Updated Successfully!\n";
        echo "Email: admin@gliders.com\n";
        echo "Password: Password@1234\n";
    }
}
