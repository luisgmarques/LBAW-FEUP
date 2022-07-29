<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_message';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(string $id) {
        $user = DB::table('users')->where('id', $id)->first();
        return $user;
    }

}