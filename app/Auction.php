<?php

namespace App;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

// Deletes auction but data remains on database

class Auction extends Model
{

    use SoftDeletes;

    public $timestamps  = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auction';

    public $fillable = [
        'seller_id',
        'item_name',
        'description',
        'starting_price',
        'current_price',
        'shipping_cost',
        'beginning_date',
        'end_date',
        'category_id',
        'auction_status',
        'payment',
        'shipping',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'seller_id' => 'integer',
        'item_name' => 'string',
        'description' => 'text',
        'starting_price' => 'real',
        'current_price' => 'real',
        'shipping_cost' => 'real',
        'beginning_date' => 'datetime',
        'end_date' => 'datetime',
        'category_id' => 'integer',
        'auction_status' => 'string',
        'payment' => 'string',
        'shipping' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function seller()
    {
        return $this->belongsTo('App\User','seller_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function category()
    {
        return $this->hasOne('App\Category', 'category_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid', 'auction_id', 'id');
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public function getCategoryName()
    {
        $categoryID = $this->category_id;
        return Category::select('id', 'name')->where('id', '=', $categoryID)->value('name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function payment()
    {
        return $this->hasOne(\App\Payment::class);
    }

    public function getTimeLeftSeconds()
    {
        $endDate = new Carbon($this->end_date, 'Europe/London');
        return Carbon::now('Europe/London')->diffInRealSeconds($endDate, true);
    }

    public function numBids()
    {
        return DB::table('bid')->where('auction_id', '=', $this->id)->count();
    }

    public function getBid()
    {
        $bid = DB::table('bid')->where('auction_id', '=', $this->id)->get()->last();

        if($bid == null)
            return false;

        if($bid->authenticated_id == auth()->user()->id)
            return true;
        else
            return false;
    }

    public function removeWishlist($user)
    {
        DB::table('wishlist')
            ->where('auction_id', '=', $this->id)
            ->where('authenticated_id', '=', $user->id)
            ->delete();
    }

    public function currentPrice()
    {
        if ($this->current_price == null)
            return $this->starting_price;
        else
            return ($this->starting_price > $this->current_price) ? $this->starting_price : $this->current_price;
    }

    public function getPhotos($id) 
    {
        return $photos = Photo::where('auction_id', $id)->get();

        
    }

    public function photos()
    {
        return $this->hasMany('App\Photo', 'auction_id', 'id');
    }
}
