<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminData = [
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@example.com',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'contact_number' => '+6134567890',
            'user_role' => 'admin',
            'user_photo' => 'default_profile_icon.png',
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => null,
        ];

        // Check if the admin user already exists
        $adminUser = User::where('email', $adminData['email'])->first();

        if (!$adminUser) {
            // Admin user doesn't exist, create it
            DB::table('users')->insert($adminData);
        }

        
        $user1Data = [
            'username' => 'Hee Jun Hua',
            'password' => Hash::make('Heejunhua'),
            'email' => 'heejunhua1231@gmail.com',
            'first_name' => 'Hee',
            'last_name' => 'Jun Hua',
            'contact_number' => '+6011234442',
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => null,
        ];
        $user2Data = [
            'username' => 'Hee Jun Hua',
            'password' => Hash::make('Heejunhua'),
            'email' => 'heejunhua@gmail.com',
            'first_name' => 'Hee',
            'last_name' => 'Jun Hua',
            'contact_number' => '+6011234442',
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => null,
        ];
        $user3Data = [
            'username' => 'Hee Jun Hua',
            'password' => Hash::make('Heejunhua'),
            'email' => 'heejh-wm20@student.tarc.edu.my',
            'first_name' => 'Hee',
            'last_name' => 'Jun Hua',
            'contact_number' => '+6011234442',
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => null,
        ];
        // Check if the user1 already exists
        $user1 = User::where('email', $user1Data['email'])->first();
        $user2 = User::where('email', $user2Data['email'])->first();
        $user3 = User::where('email', $user3Data['email'])->first();

        

        if (!$user1) {
            // User1 doesn't exist, create it
            DB::table('users')->insert($user1Data);
        }
        if (!$user2) {
            // User1 doesn't exist, create it
            DB::table('users')->insert($user2Data);
        }
        if (!$user3) {
            // User1 doesn't exist, create it
            DB::table('users')->insert($user3Data);
        }
        

        
    }
    //admin@example.com
    //admin123
}

