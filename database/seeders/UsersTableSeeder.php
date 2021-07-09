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
                'id' => 1,
                'name' => 'Super Admin',
                'username' => 'super_admin',
                'password' => '$2y$10$Qobb3WEeopz6fhvAigcMceZPil.12HUEqFJ5t8l7DzB3rd6zl54ha',
                'status' => 1,
                'avatar' => NULL,
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'username' => 'admin',
                'password' => '$2y$10$JkEEbXun.FCZCq.0JgeJcuD9GnXcaAS8shZOsYWt3B34ryAMNJcg6',
                'status' => 1,
                'avatar' => NULL,
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'warehouse',
                'username' => 'warehouse',
                'password' => '$2y$10$UeOSVyctq.oaiKcBEirqC.mnZys8H8fRxfvt9ftvAqEuB3AAKPDcK',
                'status' => 1,
                'avatar' => NULL,
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'owner',
                'username' => 'owner',
                'password' => '$2y$10$/OkMON4VLoUcFWfqTh2BCeQB5DPbyHuBDhXB3uaft29jPBM6PW4ba',
                'status' => 1,
                'avatar' => NULL,
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
        ));
        
        
    }
}