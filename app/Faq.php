<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public $timestamps  = false;

    protected $table = 'faq';

    protected $fillable = [
        'question',
        'answer',
    ];
}
