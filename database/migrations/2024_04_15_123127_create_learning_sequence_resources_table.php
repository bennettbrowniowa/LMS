<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSequenceResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_sequence_resources', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('learning_sequence_id')->unsigned();
            $table->bigInteger('resource_type_id')->unsigned();
            $table->foreign('learning_sequence_id')->references('id')->on('learning_sequences')->onDelete('cascade');
            $table->foreign('resource_type_id')->references('id')->on('resource_types')->onDelete('cascade');
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
        Schema::dropIfExists('learning_sequence_resources');
    }
}
