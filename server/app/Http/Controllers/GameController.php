<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\GameModel;
use App\GameDetailModel;
use Classes\BoardClass;
use Utils\APIResponseResult;
use Carbon\Carbon as Carbon;
use PHPUnit\Runner\Exception;

class GameController extends BaseController
{
  public function new(Request $request)
  {
    try
    {
      $board = new BoardClass;
      $board->new($request->rows, $request->cols, $request->mines);
      $mytime = Carbon::now();
      // Saving the new Game
      $gameModel = new GameModel;
      $gameModel->id_user = $request->id_user;
      $gameModel->rows = $request->rows;
      $gameModel->cols = $request->cols;
      $gameModel->mines = $request->mines;
      $gameModel->board = json_encode($board);
      $gameModel->ended = false;
      $gameModel->won = false;
      $gameModel->start_datetime = $mytime->toDateTimeString();
      $gameModel->end_datetime = null;
      $gameModel->save();
      // Saving the new Game Detail
      $gameDetailModel = new GameDetailModel;
      $gameDetailModel->id_game = $gameModel->id;
      $gameDetailModel->row = -1;
      $gameDetailModel->col = -1;
      $gameDetailModel->isFlag = false;
      $gameDetailModel->previous_board_state = null;
      $gameDetailModel->new_board_state = $gameModel->board;
      $gameDetailModel->save();
      return ApiResponseResult::OK($gameModel);
    }
    catch (Exception $e)
    {
      return APIResponseResult::ERROR("Error Creating a new Game. Details: " . $e->getMessage());
    }
  }

  public function get($id)
  {
    $gameModel = GameModel::find($id);
    if ($gameModel)
    {
      return ApiResponseResult::OK($gameModel);
    }
    return APIResponseResult::ERROR("Game $id doesn't exist");
  }

  public function play(Request $request, $id)
  {
    try
    {
      $gameModel = GameModel::find($id);
      if ($gameModel)
      {
        $mytime = Carbon::now();
        $gameDetailModel = GameDetailModel::where('id_game',$id)
          ->orderBy('id','desc')
          ->first();
        $board = new BoardClass;
        $board->fromJSON($gameDetailModel->new_board_state);
        if ($board->play($request->row, $request->col))
        {
          if ($board->won())
          {
            $gameModel->ended = true;
            $gameModel->won = true;
            $gameModel->end_datetime = $mytime->toDateTimeString();
          }
        }
        else
        {
          // Picked mine, the player lost
          $gameModel->ended = true;
          $gameModel->won = false;
          $gameModel->end_datetime = $mytime->toDateTimeString();
        }
        $gameModel->save();
        // Saving the Game Detail
        $newGameDetailModel = new GameDetailModel;
        $newGameDetailModel->id_game = $gameModel->id;
        $newGameDetailModel->row = $request->row;
        $newGameDetailModel->col = $request->col;
        $newGameDetailModel->isFlag = false;
        $newGameDetailModel->previous_board_state = $gameDetailModel->new_board_state;
        $newGameDetailModel->new_board_state = json_encode($board);
        $newGameDetailModel->save();
        return ApiResponseResult::OK($gameModel);
      }
      return APIResponseResult::ERROR("Game $id doesn't exist");
    }
    catch (Exception $e)
    {
      return APIResponseResult::ERROR("Error Playing on the new Game $id. Details: " . $e->getMessage());
    }
  }

  public function flag(Request $request, $id)
  {
    try
    {
      $gameModel = GameModel::find($id);
      if ($gameModel)
      {
        $gameDetailModel = GameDetailModel::where('id_game',$id)
          ->orderBy('id','desc')
          ->first();
        $board = new BoardClass;
        $board->fromJSON($gameDetailModel->new_board_state);
        $board->flag($request->row, $request->col);
        $gameModel->save();
        // Saving the Game Detail
        $newGameDetailModel = new GameDetailModel;
        $newGameDetailModel->id_game = $gameModel->id;
        $newGameDetailModel->row = $request->row;
        $newGameDetailModel->col = $request->col;
        $newGameDetailModel->isFlag = false;
        $newGameDetailModel->previous_board_state = $gameDetailModel->new_board_state;
        $newGameDetailModel->new_board_state = json_encode($board->board);
        $newGameDetailModel->save();
        return ApiResponseResult::OK($gameModel);
      }
      return APIResponseResult::ERROR("Game $id doesn't exist");
    }
    catch (Exception $e)
    {
      return APIResponseResult::ERROR("Error Playing on the new Game $id. Details: " . $e->getMessage());
    }
  }
}
