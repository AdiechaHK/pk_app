<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserImage;
use App\Sharing;
use App\Relation;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    use \App\Http\Controllers\Traits\ResponseTrait;

    public function create(Request $request) {
        /* need to place validation here */
        $user = new User;
        $user->company_name = $request->company_name;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->type = $request->type == "MAKER" ? "MAKER" : "CONSUMER";
        $user->password = Hash::make($request->password);
        $user->name = $request->fullname;
        $user->hash = str_random(32);
        $user->save();
        return $this->_res(true);
        //return response()->json(['castkingResponse' => [["success" => true]]]);
    }

    public function login(Request $request) {
        /* need to place validation here */
        $res = ['success' => false];
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            $res['message'] = "User not found.";
        } else {
            if (Hash::check($request->password, $user->password)) {
                $res['success'] = true;
                $res['user'] = $user;
            } else {
                $res['message'] = "Password not match.";
            }
        }
        return $this->_res(true, $res);
    }

    public function getAllPortfolyo(Request $request) {
        if (isset($request->user_id)) {
            $users = Sharing::where('user_id', $request->user_id)->with('avatar')->get();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $udata[] = array(
                        'id' => (string) $user->id,
                        'user_id' => (string) $user->user_id,
                        'description' => $user->description,
                        'image' => $user->avatar->path,
                    );
                }
                return $this->_res(true, $udata);
            } else {
                return $this->_res(false, ['message' => 'Portfolyo not found.']);
            }
        } else {
            return $this->_res(false, ["message" => "User ID is required."]);
        }
    }

    public function getImgPortfolyo(Request $request) {
        if (isset($request->portfollio_id) && isset($request->user_id)) {
            $user = Sharing::where('user_id', $request->user_id)->where('portfollio_id', $request->portfollio_id)->with('avatar')->get();
            if (count($user) > 0) {
                //foreach ($users as $user) {
                $udata[] = array(
                    'id' => (string) $user[0]->id,
                    'user_id' => (string) $user[0]->user_id,
                    'image' => $user[0]->avatar->path,
                    'description' => $user[0]->description,
                );
                //}
                return $this->_res(true, $udata);
            } else {
                return $this->_res(false, ['message' => 'Portfolyo not found.']);
            }
        } else {
            return $this->_res(false, ["message" => "Share ID and User ID is required."]);
        }
    }

    public function sendRequestStatus(Request $request) {
        $validator = Validator::make(Input::all(), Relation::$rules_status_request);
        if ($validator->passes()) {
            $relation = new Relation;
            $relation->maker_id = $request->maker_id;
            $relation->user_id = $request->user_id;
            $relation->status = $request->status;
            $relation->save();
            return $this->_res(true, ["message" => "Status request has been send successfully."]);
        } else {
            $response = $validator->messages();
            return $this->_res(false, $response->all());
        }
    }

    public function getAllConversion(Request $request) {
        if (isset($request->user_id)) {
            $udata = [];
            $users = Relation::where('user_id', $request->user_id)
                    ->where('status', 'Approve')
                    //->with('avatar')
                    ->with('userdetail')
                    ->get();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $udata[] = array(
                        'id' => (string) $user->id,
                        'user_id' => (string) $user->user_id,
                        'makerName' => $user->userdetail->name,
                            //'image' => $user->avatar->path,
                            //'description' => $user->description,
                    );
                }
                return $this->_res(true, $udata);
            } else {
                return $this->_res(false, ['message' => 'Conversion not found.']);
            }
        } else {
            return $this->_res(false, ["message" => "User ID is required."]);
        }
    }

    public function getConversionProduct(Request $request) {
        if (isset($request->id)) {
            $udata = [];
            $user = Relation::where('id', $request->id)
                    ->where('status', 'Approve')
                    ->with('userdetail')
                    ->get();
            if (count($user) > 0) {
                $udata[] = array(
                    'id' => (string) $user[0]->id,
                    'user_id' => (string) $user[0]->user_id,
                    'makerName' => $user[0]->userdetail->name,
                        //'image' => $user[0]->avatar->path,
                        //'description' => $user[0]->description,
                );
                return $this->_res(true, $udata);
            } else {
                return $this->_res(false, ['message' => 'Conversion not found.']);
            }
        } else {
            return $this->_res(false, ["message" => "ID is required."]);
        }
    }

}
