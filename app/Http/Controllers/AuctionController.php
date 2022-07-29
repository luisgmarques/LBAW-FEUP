<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;

use App\Auction;
use App\Wishlist;
use App\Category;
use App\User;
use App\Bid;
use App\Photo;

class AuctionController extends Controller
{

    public function __construct()
    {
        /** Only authenticated users can create auctions */
        $this->middleware('auth')->only('create');
    }

   
    /**
     * Display a listing of the Auction.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new Auction.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('auction.create', compact('categories'));
    }

    /**
     * Store a newly created Auction in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store()
    {
        $data = request()->validate([
            'item_name' => 'required|string',
            'description' => 'required',
            'starting_price' => 'required|numeric',
            'end_date' => 'required|date',
            'payment' => 'required|string',
            'shipping' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'photo1' => 'image',
            'photo2' => 'image',
            'photo3' => 'image',
        ]);

        $categories = Category::all();
        
        foreach ($categories as $category) {
            if ($category->name == request()['category'])
                $category_id = $category->id; 
        }

        $auction =
            
        auth()->user()->auctions()->create([
            'item_name' => $data['item_name'],
            'category_id' => $category_id,
            'description' => $data['description'],
            'starting_price' => $data['starting_price'],
            'current_price' => $data['starting_price'],
            'end_date' => $data['end_date'],
            'payment' => $data['payment'],
            'shipping' => $data['shipping'],
            'shipping_cost' => $data['shipping_cost'],
        ]);
        

        $photos = array();

        if (request('photo1')) {

            $photoPath1 = request('photo1')->store('uploads', 'public');
            $photos[] = $photoPath1;
            $photo1 = Image::make(public_path("storage/{$photoPath1}"))->fit(1280, 720);
            
            $photo1->save();
        }


        if (request('photo2')) {

            $photoPath2 = request('photo2')->store('uploads', 'public');
            $photos[] = $photoPath2;
            $photo2 = Image::make(public_path("storage/{$photoPath2}"))->fit(1280, 720);
            $photo2->save();
        }

        if (request('photo3')) {

            $photoPath3 = request('photo3')->store('uploads', 'public');
            $photos[] = $photoPath3;
            $photo3 = Image::make(public_path("storage/{$photoPath3}"))->fit(1280, 720);
            $photo3->save();
        }


        foreach($photos as $photo) {
            $savePhoto = new Photo();
            $savePhoto->auction_id = $auction['id'];
            $savePhoto->path = $photo;
            
            $savePhoto->save();
        }

        $auction_id = auth()->user()->auctions()->pluck('id')->pop(); // pluck() -> retrieves all user auctions ids / pop() -> returns last id

        return redirect('/auction/' . $auction_id);
    }

    /**
     * Display the specified Auction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Auction $auction)
    {

        $bids = Bid::where('auction_id', '=', $auction->id)
            ->orderBy('date', 'desc')->take(5)->get();

        $auction_photos = Photo::where('auction_id', $auction->id)->get();

        return view('auction.show', compact('auction', 'auction_photos', 'bids'));
    }

    /**
     * Show the form for editing the specified Auction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Auction $auction)
    {
        // Only the auction owner can edit
        $this->authorize('update', $auction);
        $categories = Category::all();
        return view('auction.edit', compact('auction', 'categories'));
    }

    /**
     * Update the specified Auction in storage.
     *
     * @param  int              $id
     * @param Request $request
     *
     * @return Response
     */
    public function update(Auction $auction)
    {
        // Only the auction owner can update
        $this->authorize('update', $auction);

        $data = request()->validate([
            'item_name' => 'required|string',
            'description' => 'required',
            'end_date' => 'required|date',
            'payment' => 'required|string',
            'shipping' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'photo1' => 'image',
            'photo2' => 'image',
            'photo3' => 'image',
        ]);

        $categories = Category::all();
        
        foreach ($categories as $category) {
            if ($category->name == request()['category'])
                $category_id = $category->id; 
        }
        
        $photos = array();

        if (request('photo1')) {
            
            $photoPath1 = request('photo1')->store('uploads', 'public');
            $photos[] = $photoPath1;
            $photo1 = Image::make(public_path("storage/{$photoPath1}"))->fit(1280, 720);
            
            $photo1->save();
        }


        if (request('photo2')) {
            
            $photoPath2 = request('photo2')->store('uploads', 'public');
            $photos[] = $photoPath2;
            $photo2 = Image::make(public_path("storage/{$photoPath2}"))->fit(1280, 720);
            $photo2->save();
        }

        if (request('photo3')) {

            $photoPath3 = request('photo3')->store('uploads', 'public');
            $photos[] = $photoPath3;
            $photo3 = Image::make(public_path("storage/{$photoPath3}"))->fit(1280, 720);
            $photo3->save();
        }


        foreach($photos as $i => $photo) {
            $auction->photos[$i]->path=$photo;

            
            
            $auction->photos[$i]->update();
        }

        $auction->update($data);


        return redirect("/auction/{$auction->id}")->with('status', 'Auction updated');

        
    }

    /**
     * Remove the specified Auction from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
       //
    }

    public function softDelete(Auction $auction)
    {
        if ($auction) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $auction);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }

    public function addToWishlist(int $id)
    {

            $wishlist = new Wishlist();
            $wishlist->auction_id = $id;
            $wishlist->authenticated_id = auth()->user()->id;

            $wishlist->save();


        return redirect('auction/' . $id);
    }

    public function removeFromWishlist($auction_id)
    {
        $auction = Auction::findOrFail($auction_id);
        $auction->removeWishlist(auth()->user());

        return redirect('auction/' . $auction_id);
    }

    public function makeBid() 
    {
        $data = request()->validate([
            'authenticated_id' => 'required',
            'auction_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $auctions = Auction::where('id', $data['auction_id'])->get();

        foreach($auctions as $auction) {
            if ($auction->current_price >= $data['amount']) 
                return redirect('/auction/'.$data['auction_id'])->with('status', 'Bid amount not valid.');
            
            $auction->current_price = $data['amount'];
            $auction->save();
            break;
        }

        $bid = new Bid();

        $bid->create([
            'authenticated_id' => $data['authenticated_id'],
            'auction_id' => $data['auction_id'],
            'amount' => $data['amount'],
        ]);

        return redirect('/auction/'.$data['auction_id'])->with('status', 'Bid with success!');
    }
}

