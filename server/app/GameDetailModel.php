<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameDetailModel extends Model {

  protected $table = 'game_detail';

  protected $fillable = [
    'id_game',
    'row',
    'col',
    'isFlag',
    'previous_board_state',
    'new_board_state'
  ];

  protected $dates = [];

  public static $rules = [
    // Validation rules
    'id_game' => 'required',
    'row' => 'required',
    'col' => 'required',
    'isFlag' => 'required',
    'previous_board_state' => 'required',
    'new_board_state' => 'required'
  ];

}

?>