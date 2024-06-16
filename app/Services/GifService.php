<?php

namespace App\Services;

use App\Data\Gif\GifDTO;
use App\Data\Gif\SearchRequestDTO;
use App\Events\GifBookmarked;
use App\Events\GifGetByIdPerformed;
use App\Events\GifSearchPerformed;
use App\Http\Requests\Gif\BookmarkRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Gif\SearchRequest as GiphySearchRequest;
use App\Models\BookmarkGif;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GifService
{

    private Client $client;
    private string $apiKey;

    private const GIPHY_SEARCH_URL  = 'https://api.giphy.com/v1/gifs/search';
    private const GIPHY_GIF_URL     = 'https://api.giphy.com/v1/gifs/';


    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('giphy.access_token');
    }


    public function searchGif(GiphySearchRequest $request): JsonResponse
    {
        $query = $request->input('QUERY');
        $limit = $request->input('LIMIT', 10);
        $offset = $request->input('OFFSET', 0);

        try {
            $response = $this->client->get(self::GIPHY_SEARCH_URL, [
                'query' => [
                    'api_key' => $this->apiKey,
                    'q' => $query,
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]);

            $gifResponseDTO = $this->createResponseDTO($response);
            $requestDTO = new SearchRequestDTO($request);

            $responseAPI = $this->prepareSuccessResponse($gifResponseDTO);
            $responseHTTP = 200;
        } catch (RequestException $e) {
            $responseAPI = $this->prepareErrorResponse($e);
            $responseHTTP = 500;
        }

        GifSearchPerformed::dispatch($gifResponseDTO ?? null, $requestDTO ?? null, $responseHTTP);

        return response()->json($responseAPI, $responseHTTP);
    }



    public function getById(Request $request, string $gifID): JsonResponse
    {
        if (empty($gifID)) {
            return response()->json([
                "status"  => false,
                "message" => "ID is required",
            ], 400);
        }

        try {
            $response = $this->client->get(self::GIPHY_GIF_URL . $gifID, [
                'query' => [
                    'api_key' => $this->apiKey,
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);
            $gifResponseDTO = $this->createGifDTO($responseBody['data']);

            GifGetByIdPerformed::dispatch($gifResponseDTO, $request, $gifID);


            return response()->json([
                "status"      => true,
                "message"     => "GIF found!",
                "gifResponse" => $gifResponseDTO
            ]);
        } catch (RequestException $e) {
            return response()->json([
                "status"  => false,
                "message" => "Error retrieving the GIF",
                "error"   => $e->getMessage()
            ], 500);
        }
    }

    public function addBookmark(BookmarkRequest $request): JsonResponse
    {

        try {

            BookmarkGif::create([
                'user_id' => Auth::id(),
                'gif_id'  => $request->id,
                'alias'   => $request->alias,
            ]);


            GifBookmarked::dispatch($request);


            return response()->json([
                "status"      => true,
                "message"     => "GIF bookmarked successfully.",
            ]);
        } catch (RequestException $e) {
            return response()->json([
                "status"  => false,
                "message" => "Error bookmarked the GIF",
            ], 500);
        }
    }


    private function createResponseDTO($response)
    {
        $responseBody = json_decode($response->getBody(), true);
        $gifDTOs = [];

        foreach ($responseBody['data'] as $gif) {
            $gifDTOs[] = $this->createGifDTO($gif);
        }

        return $gifDTOs;
    }

    private function createGifDTO($gifData)
    {
        return GifDTO::from([
            'id'    => $gifData['id'],
            'type'  => $gifData['type'],
            'url'   => $gifData['url'],
            'slug'  => $gifData['slug'],
            'title' => $gifData['title'],
        ]);
    }

    private function prepareSuccessResponse($gifResponseDTO): array
    {
        if (empty($gifResponseDTO)) {
            return [
                "status" => true,
                "message" => "No results",
                "gifResponse" => [],
            ];
        }

        return [
            "status" => true,
            "message" => "Search completed",
            "gifResponse" => $gifResponseDTO,
        ];
    }

    private function prepareErrorResponse(RequestException $e): array
    {
        return [
            "status" => false,
            "message" => "Error searching for GIFs",
            "error" => $e->getMessage(),
        ];
    }
}
