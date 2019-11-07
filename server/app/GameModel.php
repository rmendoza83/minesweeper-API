<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameModel extends Model {

  protected $table = 'game';

  protected $fillable = [
    'id_user',
    'rows',
    'cols',
    'mines',
    'board',
    'ended',
    'won',
    'start_datetime',
    'end_datetime'
  ];

  protected $dates = [
  'start_datetime',
  'end_datetime'
  ];

  public static $rules = [
    // Validation rules
    'id_user' => 'required',
    'rows' => 'required',
    'cols' => 'required',
    'mines' => 'required',
    'board' => 'required',
    'ended' => 'required',
    'won' => 'required',
    'start_datetime' => 'required',
    'end_datetime' => 'required'
  ];

}

?>