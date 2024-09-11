<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVerifiedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_verified')->default(0)->after('remember_token');
            $table->integer('is_profile_completed')->nullable()->after('is_verified');
            $table->integer('is_blocked')->nullable()->after('is_profile_completed');
            $table->string('auth_type')->nullable()->after('is_blocked');
            $table->string('github_id')->nullable()->after('auth_type');
            $table->string('github_user_name')->nullable()->after('github_id');
            $table->integer('current_team_id')->nullable()->after('github_user_name');
            $table->text('two_factor_secret')->nullable()->after('current_team_id');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
