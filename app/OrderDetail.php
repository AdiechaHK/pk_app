<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

    protected $table = 'order_detail';
    public $timestamps = false;
    protected $primaryKey = 'id';

}
