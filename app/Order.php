<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'order';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public static $rules_create_order = array(
        'maker_id' => 'required',
        'user_id' => 'required',
        'odate' => 'required',
        'description' => 'required',
        'status' => 'required',
    );
    public static $rules_update_order = array(
        'id' => 'required',
        'maker_id' => 'required',
        'user_id' => 'required',
        'odate' => 'required',
        'description' => 'required',
        'status' => 'required',
    );
    public static $rules_order_maker = array(
        'id' => 'required'
    );

    public function avatar() {
        return $this->belongsToMany(Image::class, 'order_detail', 'portfollio_id', 'id');
    }

    public function orderdetail() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
