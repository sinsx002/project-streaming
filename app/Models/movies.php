<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movies extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id_movie';
    public $timestamps = false;

    public function genre()
    {
        return $this->belongsTo(genres::class, 'id_genre', 'id_genre');
    }

    protected $fillable = ['id_genre', 'title', 'description', 'release_date', 'thumbnail', 'duration'];
}