<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('website_url');
            $table->string('google_auth_share_drive_email');
            $table->string('github_user_name');
            $table->string('slack_mail_id');
            $table->string('linkdin_link');
            $table->string('twiter_link');
            $table->string('exprience_short_desc');
            $table->enum('is_other_checked', ['Yes', 'No'])->default('No');
            $table->text('other_value_text')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructor_infos');
    }
}
