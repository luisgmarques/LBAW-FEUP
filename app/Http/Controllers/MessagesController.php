<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Message $mess)
    {
        $data = request()->validate([
            'message' => 'required|string',
            'receiver_id' => 'required',
        ]);


        if(intval($data['receiver_id']) > 0)
        {
            $receiver_id = $data['receiver_id'];
        }
        else
        {
                $receiver_id = DB::table('users')->where('username', $data['receiver_id'])->pluck('id')[0];
        }

        $message = new Message();
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $receiver_id;
        $message->message = $data['message'];
        $message->save();

        $messages_sender = Message::where('sender_id', auth()->user()->id)->with('user')->get();
        $messages_receiver = Message::where('receiver_id', auth()->user()->id)->with('user')->get();

        return view('messages.index', compact('messages_receiver','messages_sender'));
    }

    public function index()
    {
        $messages_sender = Message::where('sender_id', auth()->user()->id)->with('user')->get();
        $messages_receiver = Message::where('receiver_id', auth()->user()->id)->with('user')->get();

        return view('messages.index', compact('messages_receiver','messages_sender'));
    }

    public function show(Message $message)
    {
        return view('messages.show', compact('message'));
    }
}
