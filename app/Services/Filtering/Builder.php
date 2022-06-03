<?php

namespace App\Services\Filtering;

use App\Models\StockTicker;
use App\Services\Filtering\StockAttribute\Close;
use App\Services\Filtering\StockAttribute\High;
use App\Services\Filtering\StockAttribute\Low;
use App\Services\Filtering\StockAttribute\Open;

class Builder
{
    const FILTER_MAP = [
        'Low' => Low::class,
        'High' => High::class,
        'Close' => Close::class,
        'Open' => Open::class
    ];

    public function filter(array $filterPayload)
    {
        $tickers = StockTicker
            ::select('name')
            ->get();

        
    }

    private function buildFilter(array $filterPayload)
    {

    }
}
