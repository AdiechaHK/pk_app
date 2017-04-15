<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

    protected $table = 'chat';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public static $rules_send_chat = array(
        'maker_id' => 'required',
        'user_id' => 'required',
        'message' => 'required',
    );

}
