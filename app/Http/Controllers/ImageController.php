<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Image;

class ImageController extends Controller
{
  //
  public function form(Request $request) {
    return view('image_form');
  }

  public function save(Request $request) {
    $path = $request->file('file')->store('public/files');
    $image = new Image;
    $image->path = $path;
    $image->save();
    return response()->json(['status' => "success", 'image' => $image]);
  }

  public function display_image_page(Request $request) {
    $id = $request->id;
    return view('image_show', ['image' => $id]);
  }

  public function show(Request $request){
    $id = $request->id;
  
    $image = Image::find($id);

    if($image == null) return response()->json(["status" => "fail", "message" => "Image not found"]);

    $file = Storage::disk('local')->get($image->path);

    return response($file, 200)
              ->header('Content-Type', 'jpeg/image');
  }
}
