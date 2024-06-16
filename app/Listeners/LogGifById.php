<?php

namespace App\Listeners;

use App\Models\GifServiceType;

class LogGifById extends LogGifBase
{
    protected function prepareRequestData(object $event): array
    {
        return ['id' => $event->gif_id];
    }

    protected function getApiServiceTypeId(): int
    {
        return GifServiceType::where('name', 'Get by ID')->first()->id;
    }
}
