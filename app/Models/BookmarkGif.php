<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkGif extends Model
{
    use HasFactory;

    protected $table = 'bookmark_gifs';

    protected $fillable = ['user_id', 'gif_id', 'alias'];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
