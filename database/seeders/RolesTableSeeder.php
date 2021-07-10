<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'super_admin',
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'admin',
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'warehouse',
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'owner',
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'supplier',
                'created_at' => '2021-07-08',
                'updated_at' => '2021-07-08',
            ),
        ));


    }
}
