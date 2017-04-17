<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model {

    protected $table = 'user_image';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function avatar() {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

}
