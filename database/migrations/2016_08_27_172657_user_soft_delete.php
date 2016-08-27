<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class UserSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $usersDeleted = User::withTrashed()
            ->get();

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        foreach ($usersDeleted as $user) {
            $user->forceDelete();
        }
    }
}
