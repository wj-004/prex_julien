<?php

namespace Database\Seeders;

use App\Models\GifServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GifServiceTypeSeeder extends Seeder
{

    public function run(): void
    {

        GifServiceType::firstOrCreate([
            'name' => "Search",
        ], [
            'parameters' => json_encode([
                'QUERY'     => 'required',
                'LIMIT'     => 'numeric',
                'OFFSET'    => 'numeric',
            ]),
            'description'   => "GIPHY Search gives you instant access to our library of millions of GIFs and Stickers by entering a word or phrase. With our unparalleled search algorithm, users can easily express themselves and animate their conversations.",
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);


        GifServiceType::firstOrCreate([
            'name' => "Get by ID",
        ], [
            'parameters'    => json_encode([
                'ID'     => 'required',
            ]),
            'description'   => "Get GIF by ID returns a GIF's metadata based on the GIF ID specified.",
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        GifServiceType::firstOrCreate([
            'name' => "Add Bookmark",
        ], [
            'parameters'    => json_encode([
                'GIF_ID'    => 'required',
                'USER_ID'   => 'required',
                'ALIAS'     => 'required',
            ]),
            'description'   => "Bookmark a GIF.",
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
