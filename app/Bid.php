<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bid extends Model
{
  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  public $fillable = [
    'amount',
    'date',
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'id' => 'integer',
      'authenticated_id' => 'integer',
      'auction_id' => 'integer',
      'amount' => 'real',
      'date' => 'datetime',
  ];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'bid';

  public function user()
  {
    return $this->belongsTo('App\User','authenticated_id','id');
  }

  public function auction()
  {
    return $this->belongsTo('App\Auction','auction_id','id');
  }

  public static function create(array $data)
  {
      DB::table('bid')->insert($data);
  }

    public static function isBidBigger($bid, $auctionID){
        $auction = Auction::findOrFail($auctionID);
        if($bid < $auction->current_price)
            return false;
        return true;
    }

}