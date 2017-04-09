<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class UserController extends Controller
{
    //
  public function create(Request $request) {

    /* need to place validation here */

    $user = new User;
    $user->company_name = $request->company_name;
    $user->email = $request->email;
    $user->mobile_number = $request->mobile_number;
    $user->type = $request->type == "MAKER"? "MAKER": "CONSUMER";
    $user->password = Hash::make($request->password);
    $user->name = $request->fullname;
    $user->hash = str_random(32);
    $user->save();

    return response()->json(['castkingResponse'=>[["success"=>true]]]);


  }

  public function login(Request $request) {

    /* need to place validation here */

    $res = ['success' => false];

    $user = User::where('email', $request->email)->first();

    if($user == null) {
      $res['message'] = "User not found.";
    } else {
      if(Hash::check($request->password, $user->password)) {
        $res['success'] = true;
        $res['user'] = $user;
      } else {
        $res['message'] = "Password not match.";
      }
    }

    return response()->json(['castkingResponse' => [$res]]);


  }

  public function getAllPortfolyo() {
      $user = DB::table('users')
              ->join('images', 'users.image', '=', 'images.id')
              ->select('images.name as img_name', 'images.path as img_path', 'users.name', 'users.image', 'users.user_id')
              ->get();
      if (count($user) > 0) {
          $udata = array(
              'user_id' => $user->user_id,
              'image' => $user->img_path,
          );
          return response()->json(['castkingResponse' => [$udata]]);
      } else {
          return response()->json(['castkingResponse' => [['success' => false]]]);
      }
  }

  public function getImgPortfolyo(Request $request) {
      $users = DB::table('users')
              ->where('users.id', $request->id)
              ->join('images', 'users.image', '=', 'images.id')
              ->select('images.name as img_name', 'images.path as img_path', 'users.name', 'users.image', 'users.user_id')
              ->get();
      if (count($users) > 0) {
          foreach ($users as $user) {
              $udata[] = array(
                  'user_id' => $user->user_id,
                  'image' => $user->img_path,
              );
          }
          return response()->json(['castkingResponse' => [$udata]]);
      } else {
          return response()->json(['castkingResponse' => [['success' => false]]]);
      }
  }

}
