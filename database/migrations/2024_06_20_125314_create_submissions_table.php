<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->bigInteger('learning_sequence_id')->unsigned();
            $table->longText('description')->nullable();
            $table->longText('content_type');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('learning_sequence_id')->references('id')->on('learning_sequences')->onDelete('cascade');
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
        Schema::dropIfExists('submissions');
    }
}
