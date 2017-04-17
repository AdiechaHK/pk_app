<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model {

    protected $table = 'relation';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public static $rules_status_request = array(
        'maker_id' => 'required',
        'user_id' => 'required',
        'status' => 'required',
    );

    public function avatar() {
        return $this->belongsTo(Image::class, 'portfollio_id', 'id');
    }

    public function userdetail() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
