<?php

namespace App\Listeners;

use App\Models\GifServiceType;

class LogGifSearch extends LogGifBase
{
    protected function prepareRequestData(object $event): array
    {
        $requestData = clone $event->requestDTO;
        unset($requestData->ip_client);
        return (array) $requestData;
    }

    protected function getApiServiceTypeId(): int
    {
        return GifServiceType::where('name', 'search')->first()->id;
    }
}
