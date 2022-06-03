<?php

namespace App\Http\Controllers;

use App\Models\StockDataDaily;
use App\Models\StockTicker;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DetailController
{
    public function showDetail(Request $request, string $ticker)
    {
        // Carbon
        $stockTicker = StockTicker
            ::where('symbol', $ticker)
            ->firstOrFail();
        
        $stockDataDaily = StockDataDaily
            ::where('stock_ticker_id', $stockTicker->id)
            ->orderBy('time', 'DESC')
            ->get();
        
        $transformed = $stockDataDaily
            ->map(function (StockDataDaily $data) {
                return [
                    'x' => [
                        'year' => (int) $data->time->format('Y'),
                        'month' => (int) $data->time->format('n'),
                        'date' => (int) $data->time->format('j')
                    ],
                    'y' => [
                        (float) $data->open,
                        (float) $data->high,
                        (float) $data->low,
                        (float) $data->close
                    ]
                ];
            });

        return view('detail', [
            'transformed' => $transformed
        ]);
    }
}
