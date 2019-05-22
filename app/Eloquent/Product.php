<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
//    protected $table = 'news';
//    protected $primaryKey = 'id';
    protected $fillable = [
        'rank',
        'authorId',
        'categoryId',
        'name',
        'price',
        'image',
        'total',
    ];
}
