<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
  public function avatar() {
    return $this->belongsTo(Image::class, 'image', 'id');
  }
}
