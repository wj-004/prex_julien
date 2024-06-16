<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GifServiceType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gif_service_types';

    protected $fillable = [
        'name',
        'description',
        'parameters'
    ];


    function gifApiRequests()
    {
        return $this->hasMany(GifApiRequest::class);
    }
}
