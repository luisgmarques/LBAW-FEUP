<?php

namespace App\Http\Controllers;

use App\Report;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Intervention\Image\Facades\Image;


use App\User;

class UserController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the User profile for a given user.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('user.profile', compact('user'));
    }



    public function edit(User $user)
    {
        // Only the profile owner can edit
        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }



    public function update(User $user)
    {
        // Only the profile owner can update
        $this->authorize('update', $user);

        $data = request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'address' => 'required|string',
            'zip_code' => 'required|string',
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            'profile_pic' => ''
        ]);
        
        if (request('profile_pic')) {
            $imagePath = request('profile_pic')->store('profile', 'public');
                
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['profile_pic' => $imagePath];
        }

        auth()->user()->update(array_merge(
            $data,
            $imageArray ?? [] // 
        ));

        return redirect("/profile/{$user->id}")->with('status', 'Profile updated');
    }

    public function addReview(User $user) {

        $data = request()->validate([
                'seller_id' => 'required|string',
                'comment' => 'required|string',
                'rating' => 'required|integer',
            ]);

            $review = new Review();
            $review->buyer_id = auth()->user()->id;
            $review->seller_id = $data['seller_id'];
            $review->rating = $data['rating'];
            $review->comment = $data['comment'];
            $review->save();

            return redirect()->back();
    }

    public function addReport(User $user) {

        $data = request()->validate([
            'user_id' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $report = new Report();
        $report->authenticated_id = auth()->user()->id;
        $report->user_id = $data['user_id'];
        $report->title = $data['title'];
        $report->content = $data['content'];
        $report->report_status = "Open";
        $report->save();

        return redirect()->back();
    }

    public function softDelete(User $user)
    {
      $this->authorize('softDelete', $user);

        $message;
        if ($user->delete()) {
            $message = "User deleted";
        } else {

            $message = "User not found";
        }
        return redirect()->back()->with('status', $message);
    }
  
    public function AuthRouteAPI(Request $request) {
        return $request->user();
    }
}
