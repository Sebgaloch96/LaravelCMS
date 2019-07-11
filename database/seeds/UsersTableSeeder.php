<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'sebgal7@yahoo.co.uk')->first();

        if(!$user){
            User::create([
                'name' => 'Sebastian Galoch',
                'email' => 'sebgal7@yahoo.co.uk',
                'role' => 'admin',
                'password' => Hash::make('password')
            ]);
        }
    }
}
