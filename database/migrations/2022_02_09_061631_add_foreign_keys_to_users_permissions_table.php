<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_permissions', function (Blueprint $table) {
            $table->foreign(['user_id'], 'users_permissions_ibfk_1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['permission_id'], 'users_permissions_ibfk_2')->references(['id'])->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_permissions', function (Blueprint $table) {
            $table->dropForeign('users_permissions_ibfk_1');
            $table->dropForeign('users_permissions_ibfk_2');
        });
    }
}
