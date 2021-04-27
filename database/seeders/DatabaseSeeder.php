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
        $UserAdmin = new \App\Models\User;
        $UserAdmin->name='Super Admin';
        $UserAdmin->username='super_admin';
        $UserAdmin->password=bcrypt('super_admin');
        $UserAdmin->status=1;
        $UserAdmin->save();

        $RoleAdmin = new \App\Models\Role;
        $RoleAdmin->name='super_admin';
        $RoleAdmin->save();

        $UserRole = new \App\Models\RoleUser;
        $UserRole->user_id=1;
        $UserRole->role_id=1;
        $UserRole->save();
    }
}
