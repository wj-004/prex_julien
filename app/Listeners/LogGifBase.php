<?php

namespace App\Listeners;

use App\Models\GifApiRequest;
use App\Services\GifService;
use Illuminate\Support\Facades\Auth;

abstract class LogGifBase
{
    protected GifService $gifService;

    public function __construct(GifService $gifService)
    {
        $this->gifService = $gifService;
    }

    public function handle(object $event): void
    {
        $requestData = $this->prepareRequestData($event);
        $apiServiceTypeId = $this->getApiServiceTypeId();

        GifApiRequest::create([
            'user_id' => Auth::id(),
            'api_service_type_id' => $apiServiceTypeId,
            'request_data' => $requestData,
            'response_http' => 200,
            'response_data' => $event->gifResponseDTO,
            'ip_client' => $this->getClientIp($event),
        ]);
    }

    abstract protected function prepareRequestData(object $event): array;

    abstract protected function getApiServiceTypeId(): int;

    protected function getClientIp(object $event): string
    {
        return $event->requestDTO->ip_client ?? $event->request->ip();
    }
}
