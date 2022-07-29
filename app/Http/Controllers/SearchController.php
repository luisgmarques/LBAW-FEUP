<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Auction;
use App\Photo;
use App\Category;

class SearchController extends Controller
{
    public function search()
    {
        $auctions = Auction::where('item_name', 'like', '%'.request()->all()['query'].'%')->get();
        $categories = Category::all();
        $auction_photos = array();
        foreach ($auctions as $auction) {
            array_push($auction_photos, Photo::where('auction_id', $auction->id)->first());
        }
        return view('pages.searchpage', compact('auctions', 'auction_photos', 'categories'));
    }
}
