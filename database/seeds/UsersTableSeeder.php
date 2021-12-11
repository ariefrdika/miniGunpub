<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'name' => "Admin",                
                'email' => "admin@admin.com",
                'remember_token' => str_random(60),
                'password' => bcrypt('admin'),
                'level_user' => 0
            ],
            [
                'name' => "Staff",                
                'email' => "staff@staff.com",
                'remember_token' => str_random(60),
                'password' => bcrypt('staff'),
                'level_user' => 1
            ]
        ]);
    }
}
