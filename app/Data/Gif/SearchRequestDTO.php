<?php

namespace App\Data\Gif;

use App\Http\Requests\Gif\SearchRequest;
use Spatie\LaravelData\Data;

class SearchRequestDTO extends Data
{

    public $query;
    public $limit;
    public $offset;
    public $ip_client;

    public function __construct(SearchRequest $request)
    {
        $this->query  = $request->input('QUERY');
        $this->limit  = $request->input('LIMIT', 10);
        $this->offset = $request->input('OFFSET', 0);
        $this->ip_client = $request->ip();
    }

}
