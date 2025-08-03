<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // প্রথমে রোল এবং পারমিশন তৈরি করা হবে
        $this->call(RolePermissionSeeder::class);

        // একজন ডিফল্ট অ্যাডমিন ব্যবহারকারী তৈরি করা
        $admin = User::firstOrCreate(
            ['email' => 'admin@app.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');
    }
}