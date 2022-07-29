<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Auction;

class HomeController extends Controller
{
    public function show()
    {
      return view('pages.homepage');
    }

    /**
     * $n is number of auctions
     */
    public function get_recent_auction_card($n)
    {
      //query
      $auctions = Auction::where('auction_status', 'Open')->orderBy('beginning_date', 'desc')->take($n)->get();

      return $auctions;
    }
    
    /**
     * $n is number of auctions
     */
    public function get_bids_auction_card($n)
    {
      //query
      //TODO
      $auctions = Auction::where('auction_status', 'Open')->orderBy('item_name', 'asc')->take($n)->get();

      return $auctions;
    }

    /**
     * $n is number of auctions
     */
    public function get_cheapest_auction_card($n)
    {
      //query
      //TODO
      $auctions = Auction::where('auction_status', 'Open')->orderBy('current_price', 'asc')->take($n)->get();

      return $auctions;
    }

    /**
     * $n is number of auctions
     */
    public function get_random_auction_card($n)
    {
      //query
      $auctions = Auction::where('auction_status', 'Open')->inRandomOrder()->take($n)->get();

      return $auctions;
    }

        /**
     * $n is number of auctions
     */
    public function get_soon_auction_card($n)
    {
      //query
      $auctions = Auction::where('auction_status', 'Open')->orderBy('end_date', 'asc')->take($n)->get();

      return $auctions;
    }
}