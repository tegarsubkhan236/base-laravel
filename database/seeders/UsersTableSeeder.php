<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'avatar' => NULL,
                'created_at' => '2021-07-08',
                'email' => NULL,
                'id' => 1,
                'name' => 'admin',
                'password' => '$2y$10$JkEEbXun.FCZCq.0JgeJcuD9GnXcaAS8shZOsYWt3B34ryAMNJcg6',
                'status' => 1,
                'updated_at' => '2021-07-08',
                'username' => 'admin',
            ),
        ));
        
        
    }
}