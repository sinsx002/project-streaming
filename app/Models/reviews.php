<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['user_id', 'movie_id', 'rating', 'comment'];
}
