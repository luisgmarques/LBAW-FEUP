<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public $fillable = [
        'rating',
        'comment',
        'date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'buyer_id' => 'integer',
        'seller_id' => 'integer',
        'rating' => 'integer',
        'comment' => 'string',
        'date' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review';

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo('\App\User', 'buyer_id', 'id');
    }

    public static function create(array $data)
    {
        DB::table('review')->insert($data);
    }
}