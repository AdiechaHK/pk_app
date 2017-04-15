<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Chat;

class ChatController extends Controller {

    use \App\Http\Controllers\Traits\ResponseTrait;

    public function sendChatMsg(Request $request) {
        $validator = Validator::make(Input::all(), Chat::$rules_send_chat);
        if ($validator->passes()) {
            $chat = new Chat;
            $chat->maker_id = $request->maker_id;
            $chat->user_id = $request->user_id;
            $chat->message = $request->message;
            $chat->cdatetime = date('Y-m-d h:i:s');
            $chat->status = 'Unread';
            $chat->save();
            return $this->_res(true, ['message' => 'Chat has been added successfully.']);
        } else {
            $response = $validator->messages();
            return $this->_res(false, [$response->all()]);
        }
    }

    public function getChatContact(Request $request) {
        $chat = Chat::find($request->id);
        if (count($chat) > 0) {
            $chat_res = array(
                'id' => (string) $chat->id,
                'maker_id' => (string) $chat->maker_id,
                'chatmsg' => $chat->message
            );
            return $this->_res(true, [$chat_res]);
        } else {
            return $this->_res(false, ['message' => 'Chat contact not found.']);
        }
    }

    public function getAllContact(Request $request) {
        $chats = Chat::all();
        if (count($chats) > 0) {
            foreach ($chats as $chat) {
                $chat_res[] = array(
                    'id' => (string) $chat->id,
                    'maker_id' => (string) $chat->maker_id,
                    'chatmsg' => $chat->message
                );
            }
            return $this->_res(true, [$chat_res]);
        } else {
            return $this->_res(false, ['message' => 'Chat contact not found.']);
        }
    }

}
