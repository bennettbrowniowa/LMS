<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQtiResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qti_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id');
            $table->integer('student_id')->unsigned();
            $table->text('stem')->nullable();
            $table->text('key_data')->nullable();
            $table->longText('foils')->nullable();
            $table->longText('feedbacks')->nullable();
            $table->boolean('is_correct')->default(0);
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');
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
        Schema::dropIfExists('qti_responses');
    }
}
