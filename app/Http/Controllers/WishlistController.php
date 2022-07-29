<?php

namespace App\Http\Controllers;

use App\User;
use App\Auction;
use App\Bid;
use App\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auctions_id = Wishlist::where('authenticated_id', auth()->user()->id)->pluck('auction_id');
        $auctions = Auction::whereIn('id', $auctions_id)->with('seller')->get();
        $bids_id = Bid::where('authenticated_id', auth()->user()->id)->pluck('auction_id');

        $auctions_2 = Auction::whereIn('id', $bids_id)->get();
        return view('wishlist.index', compact('auctions', 'auctions_2'));
    }
}
