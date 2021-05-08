<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatRoom;
use App\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function newRoom(Request $request, $user_id)
    {
        echo $user_id;
        $room = new ChatRoom;
        $room->user_id = $user_id;
        $room->save();

        return ['message' => 'Add room success'];
    }

    public function room(Request $request, $user_id) {
        return ChatRoom::with('user')->where('user_id', $user_id)->first();
    }

    public function roomAll(Request $request) {
        return ChatRoom::with('user', 'messages')->get();
    }

    public function messages(Request $request, $roomId) {
        return ChatMessage::where('chat_room_id', $roomId)
                            ->with('user')
                            ->orderBy('created_at', 'ASC')
                            ->get();
    }

    public function newMessage(Request $request, $roomId) {
        $newMessage = new ChatMessage;
        $newMessage->user_id =  Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage( $newMessage ))->toOthers();
        return $newMessage;
    }

}
