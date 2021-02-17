<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		'role_id' => 1,
    		'name' => 'Rakib',
    		'username' => 'rakib',
    		'email' => 'rakib@gmail.com',
    		'password' => Hash::make('123456789')
    	]);
    	DB::table('users')->insert([
    		'role_id' => 2,
    		'name' => 'Author',
    		'username' => 'author',
    		'email' => 'author@gmail.com',
    		'password' => Hash::make('123456789')
    	]);
    }
}
