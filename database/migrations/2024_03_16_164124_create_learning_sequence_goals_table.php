<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSequenceGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_sequence_goals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('learning_sequence_id')->unsigned();
            $table->bigInteger('goal_id')->unsigned();
            $table->foreign('learning_sequence_id')->references('id')->on('learning_sequences')->onDelete('cascade');
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
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
        Schema::dropIfExists('learning_sequence_goals');
    }
}
