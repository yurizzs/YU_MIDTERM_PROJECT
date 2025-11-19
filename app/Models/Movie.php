<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'genre_id',
        'duration_minutes',
        'director',
        'description',
        'poster'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
