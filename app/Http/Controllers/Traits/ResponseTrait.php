<?php

namespace App\Http\Controllers\Traits;

trait ResponseTrait {

  private function _res($success, $object = null) {

    $res = ['success' => $success];
    if(isset($object)) {
      $res['data'] = $object;
    }     

    return ['castkingResponse' => [$res]];
  }

}

?>