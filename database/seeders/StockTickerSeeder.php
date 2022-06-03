<?php

namespace Database\Seeders;

use App\Models\StockDataDaily;
use Exception;
use Illuminate\Http\File;
use App\Models\StockTicker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;

class StockTickerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $stockTickerPath = database_path('data/stock-ticker-data.json');
        $jsonData = file_get_contents($stockTickerPath);
        $parsedData = json_decode($jsonData, true);

        foreach ($parsedData as $data) {
            if (!StockTicker::where('symbol', $data['ticker'])->exists()) {
                StockTicker::create([
                    'name' => $data['name'],
                    'symbol' => $data['ticker']
                ]);
            }
        }
    }
}
