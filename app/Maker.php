<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model {

    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public static $rules_maker_signup = array(
        //'tenent_id' => 'required',
        'company_name' => 'required',
        'fullname' => 'required',
        'email' => 'required|email|unique:users',
        'mobile_number' => 'required',
        'password' => 'required|min:6|max:30',
        'image' => 'required',
    );
    public static $rules_maker_update = array(
        'id' => 'required',
        //'tenent_id' => 'required',
        'company_name' => 'required',
        'fullname' => 'required',
        'email' => "required|email",
        'mobile_number' => 'required',
    );
    public static $photo_upload = array(
        'image' => 'required|image|mimes:gif,jpg,jpeg,png'
    );

}
