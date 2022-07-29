<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public $fillable = [
        'title',
        'context',
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
        'user_id' => 'integer',
        'title' => 'string',
        'context' => 'string',
        'date' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report';

    public function getAuthenticatedName()
    {
        $user_id = $this->authenticated_id;
        return DB::table('users')->where('id', '=', $user_id)->pluck('username')[0];
    }

    public function getUserName()
    {
        $user_id = $this->user_id;
        return DB::table('users')->where('id', '=', $user_id)->pluck('username')[0];
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function create(array $data)
    {
        DB::table('report')->insert($data);
    }
}