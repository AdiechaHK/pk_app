<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maker;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MakerController extends Controller {

    use \App\Http\Controllers\Traits\ResponseTrait;

    public function makerSignp(Request $request) {
        $validator = Validator::make(Input::all(), Maker::$rules_maker_signup);
        if ($validator->passes()) {
            $maker = new Maker;
            $maker->name = $request->fullname;
            $maker->company_name = $request->company_name;
            $maker->email = $request->email;
            $maker->mobile_number = $request->mobile_number;
            $maker->password = Hash::make($request->password);
            $maker->status = 'Active';
            $maker->image = $request->image;
            $maker->type = 'Maker';
            $maker->hash = str_random(32);
            $maker->save();
            return $this->_res(true, ["message" => "Maker has been created successfully."]);
        } else {
            $response = $validator->messages();
            return $this->_res(false, $response->all());
        }
    }

    public function getAllMaker() {
        $makersData = array();
        $makers = Maker::all();
        if (count($makers) > 0) {
            foreach ($makers as $maker) {
                $makersData[] = $maker;
            }
            return $this->_res(true, $makersData);
        } else {
            return $this->_res(false, ["message" => "Maker not found."]);
        }
    }

    public function getMaker(Request $request) {
        if (isset($request->id)) {
            $maker = Maker::find($request->id);
            if (count($maker) > 0) {
                return $this->_res(true, $maker);
            } else {
                return $this->_res(false, ["message" => "Maker not found."]);
            }
        } else {
            return $this->_res(false, ["message" => "Maker ID is required."]);
        }
    }

    public function updateMaker(Request $request) {
        $validator = Validator::make(Input::all(), Maker::$rules_maker_update);
        if ($validator->passes()) {
            $maker = Maker::find($request->id);
            if ($maker) {
                $maker->name = $request->fullname;
                $maker->company_name = $request->company_name;
                $maker->email = $request->email;
                $maker->mobile_number = $request->mobile_number;
                $maker->save();
                return $this->_res(true, ["message" => "Maker has been updated successfully."]);
            } else {
                return $this->_res(false, ["message" => "Maker not found."]);
            }
        } else {
            $response = $validator->messages();
            return $this->_res(false, $response->all());
        }
    }

    public function deleteMaker(Request $request) {
        if (isset($request->id)) {
            $maker = Maker::find($request->id);
            if ($maker) {
                $maker->delete();
                return $this->_res(true, ["message" => "Maker has been deleted successfully."]);
            } else {
                return $this->_res(false, ["message" => "Maker not found."]);
            }
        } else {
            return $this->_res(false, ["message" => "Maker ID is required."]);
        }
    }

}
