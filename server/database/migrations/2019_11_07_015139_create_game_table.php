<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('game', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('id_user');
      $table->integer('rows');
      $table->integer('cols');
      $table->integer('mines');
      $table->string('board',65535);
      $table->boolean('ended');
      $table->boolean('won');
      $table->dateTime('start_datetime');
      $table->dateTime('end_datetime')->nullable();
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
    Schema::dropIfExists('game');
  }
}
