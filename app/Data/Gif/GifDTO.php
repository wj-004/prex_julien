<?php

namespace App\Data\Gif;

use Spatie\LaravelData\Data;

class GifDTO extends Data
{

    public function __construct(
        public string $id,
        public string $type,
        public string $url,
        public string $slug,
        public string $title
    ) {
    }
}
