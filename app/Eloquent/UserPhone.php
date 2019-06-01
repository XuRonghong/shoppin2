<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    //
    protected $table = 'user_phones';
    //变量存储允许
    protected $fillable = ['phone'];
    //变量存储 不允许
    protected $guarded = ['id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
