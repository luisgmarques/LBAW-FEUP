<?php

namespace App\Policies;

use App\User;
use App\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuctionPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Auction $auction)
    {
      // 
    }

    public function create(User $user, Auction $auction)
    {
      //
    }

    public function update(User $user, Auction $auction)
    {
      // User can only update items in cards they own
      return $user->id == $auction->seller_id;
    }

    public function delete(User $user, Auction $auction)
    {
      // User can only delete items in cards they own
      return $user->id == $auction->seller_id;
    }

}
