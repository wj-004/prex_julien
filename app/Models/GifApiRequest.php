<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GifApiRequest extends Model
{
    use HasFactory;

    protected $table = "gif_api_requests";

    protected $fillable = [
        'user_id',
        'api_service_type_id',
        'request_data',
        'response_status',
        'response_data',
        'ip_client'
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function apiServiceType()
    {
        return $this->belongsTo(GifServiceType::class, 'api_service_type_id')->withTrashed();
    }
}
