<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Image;
use App\User;

class ContactController extends Controller
{

    use \App\Http\Controllers\Traits\ResponseTrait;

    // private static 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->user_id)) {
            return $this->_res(true, Contact::where('user_id', $request->user_id)->with('avatar')->get());
        } else {
            return $this->_res(false, ["message" => "User ID required to get contacts."]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $this->_save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        return $this->_save($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contact = Contact::find($id);
        if(isset(request()->user_id) && $contact->user_id == request()->user_id) {
            $contact->delete();
            return $this->_res(true, ["message" => "Deleted successfully"]);
        }
        return $this->_res(false, ["message" => "You do not have permission to delete the   contact."]);
    }

    private function _save($contact_id = null) {

        $request = request();

        $contact = new Contact;

        /* associate with user */
        $user = User::find($request->user_id);

        if($user == null) return $this->_res(false, ['message' => "User not found."]);

        if($contact_id == null) {
            $contact->user_id = $user->id;
        } else {
            $contact = Contact::find($contact_id);
            if($contact->user_id != $user->id) {
                return $this->_res(false, ['message' => "You do not have permission to modify this contact."]);
            }
        }

        /* storing general fields */
        $fields = ['company_name', 'firstname', 'lastname', 'email',
        'mobile_number', 'street', 'area', 'city', 'state', 'country'];
        foreach ($fields as $field) {
            if(isset($request->$field)) {
                $contact->$field = $request->$field;
            }
        }

        /* need to add logic for image save */

        $contact->save();

        return $this->_res(true, $contact);
    }

}
