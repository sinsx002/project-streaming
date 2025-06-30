<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class genres extends Model
{
    protected $table = 'genres';
    protected $primaryKey = 'id_genre';
    public $timestamps = false;
}