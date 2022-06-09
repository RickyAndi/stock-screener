<?php

namespace Database\Seeders;

use Exception;
use App\Models\StockTicker;
use App\Models\StockDataDaily;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $stockTickers = StockTicker
            ::with(['dailyData'])
            ->get();
        
        foreach ($stockTickers as $ticker) {
            try {
                if (!$ticker->dailyData->count()) {
                    if (File::exists(database_path("data/{$ticker->symbol}.json"))) {
                        $jsonContent = file_get_contents(database_path("data/{$ticker->symbol}.json"));
                        $parsedContent = json_decode($jsonContent, true);
                        
                        $toBeInserted = [];
                        foreach ($parsedContent as $data) {
                            $toBeInserted[] = [
                                'open' => (float) $data['open'],
                                'close' => (float) $data['close'],
                                'high' => (float) $data['high'],
                                'low' => (float) $data['low'],
                                'volume' => (int) $data['volume'],
                                'stock_ticker_id' => $ticker->id,
                                'time' => Carbon::createFromTimestamp(strtotime($data['date'])),
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ];
                        }

                        StockDataDaily::insert($toBeInserted);
                    }   
                }
            } catch (Exception $exception) {
                report($exception);
                
                continue;
            }
        }
    }
}
