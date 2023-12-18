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
            'username' => 'Hee Jun Hua',
            'password' => Hash::make('Heejunhua'),
            'email' => 'heejunhua1231@gmail.com',
            'first_name' => 'Hee',
            'last_name' => 'Jun Hua',
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

        
        // $user1Data = [
        //     'username' => 'Hee Jun Hua',
        //     'password' => Hash::make('Heejunhua'),
        //     'email' => 'hee@gmail.com',
        //     'first_name' => 'Hee',
        //     'last_name' => 'Jun Hua',
        //     'contact_number' => '+6011234442',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     'remember_token' => null,
        // ];
        // $user2Data = [
        //     'username' => 'Hee Jun Hua',
        //     'password' => Hash::make('Heejunhua'),
        //     'email' => 'heejunhua1231@gmail.com',
        //     'first_name' => 'Hee',
        //     'last_name' => 'Jun Hua',
        //     'contact_number' => '+6011234442',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     'remember_token' => null,
        // ];
        // $user3Data = [
        //     'username' => 'Hee Jun Hua',
        //     'password' => Hash::make('Heejunhua'),
        //     'email' => 'heejh-wm20@student.tarc.edu.my',
        //     'first_name' => 'Hee',
        //     'last_name' => 'Jun Hua',
        //     'contact_number' => '+6011234442',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     'remember_token' => null,
        // ];
        // // Check if the user1 already exists
        // $user1 = User::where('email', $user1Data['email'])->first();
        // $user2 = User::where('email', $user2Data['email'])->first();
        // $user3 = User::where('email', $user3Data['email'])->first();

        // if (!$user1) {
        //     // User1 doesn't exist, create it
        //     DB::table('users')->insert($user1Data);
        // }
        // if (!$user2) {
        //     // User1 doesn't exist, create it
        //     DB::table('users')->insert($user2Data);
        // }
        // if (!$user3) {
        //     // User1 doesn't exist, create it
        //     DB::table('users')->insert($user3Data);
        // }

        // $notificationData = [
        //     'user_id' => 3,
        //     'notification_title' => 'Welcome!',
        //     'notification_content' => 'Thank you for joining our platform.',
        //     'notification_read' => false,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ];
        
        // DB::table('notifications')->insert($notificationData);
    

        // Seed data for food_banks
        $foodBanks = [
            [
                'name' => 'Kechara Food Bank',
                'address' => '10, Jln Seri Rejang 3, Setapak Jaya, 53300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
                'latitude' => 3.19563125575697,  
                'longitude' => 101.72696308080654,
                'phone_number' => '+60124547588',
            ],
            [
                'name' => 'Angel\'s Food Bank',
                'address' => '27-1, Jalan 1/48b, Taman Sentul Jaya, 51000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
                'latitude' => 3.1930843727900267,   
                'longitude' => 101.69228169348602,
                'phone_number' => '+60124574798',
            ],
            [
                'name' => 'Cheezylicious',
                'address' => 'Redchair parking, Jalan teratai 2, jalan genting klang, taman setapak indah Genting Klang, Taman Setapak Indah, 53100 Kuala Lumpur',
                'latitude' => 3.1963845448694803, 
                'longitude' => 101.71230314534111,
                'phone_number' => '+60124568898',
            ],
            [
                'name' => 'Elewsmart Cyberjaya',
                'address' => '100-G, BLOCK M, BIZ AVENUE 2 @ NEOCYBER, Lingkaran Cyber Point Barat, 63000 Cyberjaya, Selangor',
                'latitude' => 2.9156792381056205, 
                'longitude' => 101.64929938528265,
                'phone_number' => '+60124564475',
            ],
            [
                'name' => '23, Jln TTDI Grove 7/1',
                'address' => '23, Jln TTDI Grove 7/1',
                'latitude' => 2.9972486226810315, 
                'longitude' => 101.81477899502379,
                'phone_number' => '+60122564798',
            ],
            [
                'name' => '29, Jalan Dinar D U3/D',
                'address' => '29, Jalan Dinar D U3/D, Taman Subang Perdana, 40150 Shah Alam, Selangor',
                'latitude' => 3.14886794700632,    
                'longitude' => 101.5453132576713,
                'phone_number' => '+60124954798',
            ],
            [
                'name' => 'BMS Organics',
                'address' => 'LG 44, Setia City Mall, Seksyen U13, Persiaran Setia Dagang, Shah Alam, 40170 Selangor, Malaysia',
                'latitude' => 3.1097344694464377, 
                'longitude' => 101.46021799999998,
                'phone_number' => '+60121659298',
            ],
            [
                'name' => 'SHELL STATION',
                'address' => 'Jalan Tun Jugah, Kempas Heights, 93350 Kuching, Sarawak',
                'latitude' => 1.5153546660684996, 
                'longitude' => 110.35437606904497,
                'phone_number' => '+60124464778',
            ],
            [
                'name' => 'Petronas Bandar Baru Nilai',
                'address' => 'Petronas, 9252, Persiaran Negeri, Desa Kolej, 71800 Nilai, Negeri Sembilan',
                'latitude' => 2.81213527358294,  
                'longitude' => 101.77878928836249,
                'phone_number' => '+60124647968',
            ],
            [
                'name' => 'Puchong Intan Shop Apartment',
                'address' => '4, Jalan Intan 1/2, Bandar Puteri, 47100 Puchong, Selangor',
                'latitude' => 3.020349614918286,  
                'longitude' => 101.60669132698249,
                'phone_number' => '+60127764798',
            ],
            
        ];

        // Insert data into the food_banks table
        DB::table('food_banks')->insert($foodBanks);



        // $foodItems = [
        //     [
        //         'user_id' => 3,
        //         'food_item_name' => 'Chipsters',
        //         'food_item_category' => 'snacks',
        //         'food_item_quantity' => 90,
        //         'has_expiry_date' => true,
        //         'food_item_expiry_date' => '2023-12-25',
        //         'donated' => false,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'user_id' => 3,
        //         'food_item_name' => 'Canned Lunch Meat',
        //         'food_item_category' => 'canned_goods',
        //         'food_item_quantity' => 40,
        //         'has_expiry_date' => false,
        //         'food_item_expiry_date' => null,
        //         'donated' => false,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'user_id' => 3,
        //         'food_item_name' => 'Raisins',
        //         'food_item_category' => 'dry_goods',
        //         'food_item_quantity' => 40,
        //         'has_expiry_date' => true,
        //         'food_item_expiry_date' => '2023-12-26',
        //         'donated' => false,
        //         'created_at' => now(),
        //     ],
        // ];
        // DB::table('food_items')->insert($foodItems);

        
    }
    //admin@example.com
    //admin123
}

