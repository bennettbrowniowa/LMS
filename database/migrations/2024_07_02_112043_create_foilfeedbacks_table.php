<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoilfeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foilfeedbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->bigInteger('learning_sequence_id')->unsigned();
            $table->longText('foil');
            $table->longText('feedback');
            $table->boolean('is_correct')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('foilfeedbacks');
    }
}
