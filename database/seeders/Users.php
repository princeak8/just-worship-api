<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

use App\Enums\Role;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "role" => Role::ADMIN->value,
                "password" => "admin123"
            ],
            [
                "name" => "Super Admin",
                "email" => "super-admin@gmail.com",
                "role" => Role::SUPER_ADMIN->value,
                "password" => "admin123"
            ],
            [
                "name" => "Chidi Ani",
                "email" => "chidi@gmail.com",
                "role" => Role::ADMIN->value,
                "password" => "chidi123"
            ]
        ];

        foreach($users as $userArr) {
            $user = User::where("email", $userArr['email'])->first();
            if(!$user) {
                $user = new User;
                $user->name = $userArr['name'];
                $user->email = $userArr['email'];
                $user->role = $userArr['role'];
                $user->password = $userArr['password'];
                $user->save();
            }
        }
    }
}
