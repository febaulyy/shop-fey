<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [ 
            [ 
                'name' => 'Admin', 
                'email' => 'admin@gmail.com', 
                'type' => 1, 
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ], 
            [ 
                'name' => 'User', 
                'email' => 'user@gmail.com', 
                'type' => 0, 
                'password' => bcrypt('123456'), 
                'role' => 'user'
            ], 
        ]; 
 
        foreach ($users as $key => $user) { 
            User::create($user); 
        } 

    }
}
