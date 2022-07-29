<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Notification $notification) {
        
        $data = request()->validate([
            'was_read' => 'required',
        ]);

        
        Notification::find($notification->id)->update($data);

        return redirect()->back();
    }

    public function index()
    {
        $unread_notifications = Notification::where('authenticated_id', auth()->user()->id)
            ->where('was_read', '=', false)
            ->with('user')->get();
        $read_notifications = Notification::where('authenticated_id', auth()->user()->id)
            ->where('was_read', '=', true)
            ->with('user')->get();
        
        return view('notifications.index', compact('unread_notifications', 'read_notifications'));
    }

    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }
}
