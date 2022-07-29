<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; // Deletes user but data remains on database

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $timestamps  = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'username',
        'password',
        'address',
        'zip_code',
        'email',
        'is_admin',
        'rating',
        'user_status',
        'profile_pic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
        'email' => 'string',
        'is_admin' => 'boolean',
        'is_winner' => 'boolean',
        'rating' => 'float',
        'status' => 'string',
        'profile_pic' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function auctions()
    {
        return $this->hasMany(Auction::class, 'seller_id');
    }

    public function myReviews()
    {
        return $this->hasMany('\App\Review', 'seller_id', 'id');
    }

    public function givenReviews()
    {
        return $this->hasMany('\App\Review', 'buyer_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'authenticated_id');
    }

    public function messages_sender()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messages_receiver()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Wishlist::class,'authenticated_id','id');
    }

    public function itemOnWishlist($auction) {
        $isOnList = DB::table('wishlist')->where('authenticated_id', '=', $this->id)->where('auction_id', '=', $auction->id)->count();
        if($isOnList > 0)
            return true;
        else
            return false;
    }

    public function hasWishlist()
    {
        return $this->hasOne(Wishlist::class, 'authenticated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function bidAuctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function getRating()
    {
        $reviews = DB::table('review')->where('seller_id', '=', $this->id)->pluck('rating');

        $rating = 0;

        for($i = 0; $i < $reviews->count(); $i++)
        {
            $rating = $rating + $reviews[$i];
        }

        if($reviews->count() == 0)
            $div = 1;
        else
            $div = $reviews->count();

        $final = $rating / $div;

        return $final;
    }

    public function profilePicture()
    {
        $imagePath = ($this->profile_pic) ? $this->profile_pic : 'profile/placeholder.jpg';
        return '/storage/' . $imagePath;
    }

}