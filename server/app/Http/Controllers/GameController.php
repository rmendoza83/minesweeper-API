<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Utils\APIResponseResult;

class GameController extends BaseController
{
  public function new(Request $request)
  {
    return ApiResponseResult::OK();
  }

  public function get($id)
  {
    return ApiResponseResult::OK();
  }

  public function play(Request $request, $id)
  {
    return ApiResponseResult::OK();
  }

  public function flag(Request $request, $id)
  {
    return ApiResponseResult::OK();
  }
}
