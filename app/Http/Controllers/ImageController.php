<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Image;
use App\Contact;
use App\User;

class ImageController extends Controller
{
  use \App\Http\Controllers\Traits\ResponseTrait;

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

  public function save_profile_image(Request $request) {


    $file = $request->hasFile('file')?$request->file('file'):null;

    if($file != null) {

      if(!isset($request->user_id)) {
        return $this->_res(false, ['message' => "User ID is required."]);
      }

      $user = User::find($request->user_id);

      if($user != null) {

        $path = $file->store('public/files');
        $image = new Image;
        if(isset($user->image)) $image = Image::find($user->image);
        $image->path = $path;
        $image->save();

        $user->image = $image->id;
        $user->save();

        return $this->_res(true);
      } else {
        return $this->_res(false, ['message' => "User does not exist in the system."]);
      }

    } else {
      return $this->_res(false, ['message'=> "file missing."]);
    }

  }


  public function save_portfolio_image(Request $request) {


    $file = $request->hasFile('file')?$request->file('file'):null;

    if($file != null) {

      if(!isset($request->user_id)) {
        return $this->_res(false, ['message' => "User ID is required."]);
      }

      $user = User::find($request->user_id);

      if($user != null) {

        $path = $file->store('public/files');
        $image = new Image;
        if(isset($user->image)) $image = Image::find($user->image);
        $image->path = $path;
        $image->save();

        $user->image = $image->id;
        $user->save();

        return $this->_res(true);
      } else {
        return $this->_res(false, ['message' => "User does not exist in the system."]);
      }

    } else {
      return $this->_res(false, ['message'=> "file missing."]);
    }

  }

  public function save_contact_image(Request $request) {

    $file = $request->hasFile('file')?$request->file('file'):null;

    if($file != null) {

      if(!isset($request->user_id) || !isset($request->contact_id)) {
        return $this->_res(false, ['message' => "You don't have enough permission to add photo."]);
      }

      $contact = Contact::find($request->contact_id);
      $user = User::find($request->user_id);

      if($contact->user_id != $user->id) {
        return $this->_res(false, ['message' => "You don't have enough permission to add photo."]);
      }

      if($user != null && $contact != null) {

        $path = $file->store('public/files');
        $image = new Image;
        if(isset($contact->image)) $image = Image::find($contact->image);
        $image->path = $path;
        $image->save();

        $contact->image = $image->id;
        $contact->save();

        return $this->_res(true);
      } else {
        return $this->_res(false, ['message' => "User/Contact does not exist in the system."]);
      }

    } else {
      return $this->_res(false, ['message'=> "file missing."]);
    }

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
