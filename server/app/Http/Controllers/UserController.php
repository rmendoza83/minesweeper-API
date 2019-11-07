<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

/*
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\GameModel;
use App\GameDetailModel;
use Classes\BoardClass;
use Utils\APIResponseResult;
use Carbon\Carbon as Carbon;
use PHPUnit\Runner\Exception;
*/

class UserController extends BaseController
{
  public function login(Request $request)
  {
    try
    {
      $userModel = UserModel::where('email',$request->email)
        ->first();
      if (!$userModel)
      {
        //Registering the new user
        $userModel->name = "";
        $userModel->new_user = true;
        $userModel->save();
      }
      return ApiResponseResult::OK($userModel);
    }
    catch (Exception $e)
    {
      return APIResponseResult::ERROR("Error on the user login. Details: " . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try
    {
      $userModel = UserModel::find($id);
      if ($userModel)
      {
        //Updating the new user
        $userModel->name = $request->name;
        $userModel->new_user = false;
        $userModel->save();
      }
      return ApiResponseResult::OK($userModel);
    }
    catch (Exception $e)
    {
      return APIResponseResult::ERROR("Error updating the new user. Details: " . $e->getMessage());
    }
  }
}
