<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Models\User;
        $admin->username='admin';
        $admin->password=bcrypt('admin');;
        $admin->save();
    }
}
