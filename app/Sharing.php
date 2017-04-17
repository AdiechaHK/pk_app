<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sharing extends Model {

    protected $table = 'sharing';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function avatar() {
        return $this->belongsTo(Image::class, 'portfollio_id', 'id');
    }

    public function relation() {
        return $this->belongsTo(Relation::class, 'user_id', 'user_id');
    }

    public function userdetail() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
