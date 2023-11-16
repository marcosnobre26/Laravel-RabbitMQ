<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Streaming;

class StreamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Streaming::create([
            'id' => 1,
            'name' => 'Prime Video',
            'price' => 10.50
        ]);

        Streaming::create([
            'id' => 2,
            'name' => 'Netflix',
            'price' => 11.60
        ]);

        Streaming::create([
            'id' => 3,
            'name' => 'HBO',
            'price' => 12.60
        ]);

        Streaming::create([
            'id' => 4,
            'name' => 'Disney Plus',
            'price' => 12.10
        ]);
    }
}