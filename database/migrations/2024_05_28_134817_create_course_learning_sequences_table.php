<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLearningSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_learning_sequences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('learning_sequence_id')->unsigned();
            $table->longText('title');
            $table->longText('description');
            $table->longText('content_type');
            $table->integer('order_column');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('learning_sequence_id')->references('id')->on('learning_sequences')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('course_learning_sequences');
    }
}
