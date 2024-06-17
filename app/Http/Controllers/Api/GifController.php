<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Gif\BookmarkRequest;
use App\Http\Requests\Gif\SearchRequest as GiphySearchRequest;
use App\Services\GifService as GifService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GifController extends Controller
{
    protected $giphyService;

    public function __construct(
        private GifService $gifService
    ) {
    }


    public function search(GiphySearchRequest $request): ?JsonResponse
    {
        return $this->gifService->searchGif($request);
    }

    public function getById(Request $request,string $id): ?JsonResponse
    {
        return $this->gifService->getById($request, $id);
    }

    public function addBookmark(BookmarkRequest $request): ?JsonResponse
    {
        dd($request);
        return $this->gifService->addBookmark($request);
    }
}
