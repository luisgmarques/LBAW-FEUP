<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public $fillable = [
        'description',
        'path',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'auction_id' => 'integer',
        'description' => 'string',
        'path' => 'string',
    ];


    public function auction()
    {
        return $this->belongsTo('\App\Auction','auction_id','id');
    }

    public function photoPath()
    {
        
        $imagePath = ($this->path) ? $this->path : 'uploads/banana.jpg';
        
        return '/storage/' . $imagePath;
    }
}