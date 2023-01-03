<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('opponent_id');
            $table->text('word');
            $table->text('word_1')->nullable();
            $table->text('word_2')->nullable();
            $table->text('word_3')->nullable();
            $table->text('word_4')->nullable();
            $table->text('word_5')->nullable();
            $table->text('word_6')->nullable();
            $table->boolean('seen')->default(false);
            $table->bigInteger('winner_id')->nullable();
            $table->integer('degree')->nullable();
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
        Schema::dropIfExists('games');
    }
};
