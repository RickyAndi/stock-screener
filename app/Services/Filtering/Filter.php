<?php

namespace App\Services\Filtering;

use App\Models\StockTicker;

class Filter
{
    private $filters = [];
    private $endResultChecker;

    public static function build(StockTicker $stockTicker, array $query)
    {
        foreach ($query as $modifier) {
            $modifier = Modifier::fromArray($stockTicker, $modifier);
        }
    }
}
