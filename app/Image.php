<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    //
  public static function remove_image($id) {
    $image = self::find($id);
    if(isset($image->path) && trim($image->path) != '') {
      Storage::delete($image->path);
    }
    $image->delete();
  }
}
