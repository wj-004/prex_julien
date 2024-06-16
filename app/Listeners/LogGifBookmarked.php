<?php

namespace App\Listeners;

use App\Models\GifServiceType;

class LogGifBookmarked extends LogGifBase
{
    protected function prepareRequestData(object $event): array
    {
        $requestData = clone $event->request;
        unset($requestData->ip_client);
        return (array) $requestData;
    }

    protected function getApiServiceTypeId(): int
    {
        return GifServiceType::where('name', 'Add Bookmark')->first()->id;
    }
}
