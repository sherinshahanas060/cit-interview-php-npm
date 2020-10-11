<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Database\Seeder;

class SuperadminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'id' => 1,
            'name' => 'Admin',
            'email' => "info@aizov.com",
            'is_user' => 1,
            'email_verified_at' => null,
            'password' => Hash::make('admin1234'),
            'is_employee' => 0,
            'is_delegate' => 0,
            'status' => 1,
            'remember_token' => null,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

        ];
        $usersDetail = [
            'id' => 1,
            'user_id' => 1,
            'email' => "info@aizov.com",
            'mobile_number' => "+971543232079",
            'user_status' => 1,
            'first_name' => "Admin",
            'second_name' => "Aizov",
            'gender' => 1,
            'date_of_birth' => Carbon::now()->format('Y-m-d H:i:s'),
            'nationality' => "UAE",
            "status" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

        ];

        $user = User::updateOrCreate($user);
        UserDetail::updateOrCreate($usersDetail);
    }
}
