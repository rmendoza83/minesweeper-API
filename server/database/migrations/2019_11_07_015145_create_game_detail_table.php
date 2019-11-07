<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('game_detail', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('id_game');
      $table->integer('row');
      $table->integer('col');
      $table->boolean('isFlag');
      $table->string('previous_board_state',65535)->nullable();
      $table->string('new_board_state',65535);
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
    Schema::dropIfExists('game_detail');
  }
}
