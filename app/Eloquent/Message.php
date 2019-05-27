<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
        'author',
        'title',
        'content',
        'start_at',
        'end_at'
    ];
}
