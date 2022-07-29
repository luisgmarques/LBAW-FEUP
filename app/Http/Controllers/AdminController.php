<?php

namespace App\Http\Controllers;

use App\Category;
use App\Notification;
use App\Report;
use Illuminate\Http\Request;

use App\User;
use App\Auction;
use App\Photo;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userBan(User $user)
    {
        $data = request()->validate([
            'user_status' => 'required',
        ]);


        User::find($user->id)->update($data);

        $notification = new Notification();
        $notification->subject = "User Status";
        $notification->description = "You're status was updated. Go profile to check it out!";
        $notification->was_read = false;
        $notification->authenticated_id = $user->id;
        $notification->save();

        return redirect()->back();
    }

    public function admin()
    {
        $users = User::where('is_admin', false)->orderBy('id', 'desc')->get();

        $auctions = Auction::all();
        $photos = Photo::all();

        $reports = Report::all();

        return view('pages.admin', compact('users', 'auctions', 'photos', 'reports'));
    }

    public function createCategory()
    {

        $data = request()->validate([
            'name' => 'required|string',
            ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        return redirect()->back()->with('message', 'Category added!');
    }
}