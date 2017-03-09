<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DemoController extends Controller
{
    //
  public function image_form(Request $request) {
    return view('image_form');
  }

  public function image_save(Request $request) {
    $path = $request->file('file')->store('public/files');
    dd($path);
  }

  public function image_show($filename){
  
    $file = Storage::disk('local')->get('files/' . $filename);

    return (response($file, 200))
              ->header('Content-Type', 'jpeg/image');
  }

}
