<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    public $timestamps  = false;

    protected $fillable = [
        'auction_id',
        'authenticated_id',
    ];

    public function auction() {
        return $this->belongsToMany(Auction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


}
