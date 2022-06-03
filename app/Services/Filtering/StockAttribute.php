<?php

namespace App\Services\Filtering;

use App\Models\StockDataDaily;
use App\Models\StockTicker;
use App\Services\Filtering\Enums\StockAttributeEnum;
use Illuminate\Support\Carbon;

class StockAttribute
{
    private $modifier;
    private $stockTicker;

    public function __construct(
        array $modifier,
        StockTicker $stockTicker 
    )
    {
        $this->modifier = $modifier;
        $this->stockTicker = $stockTicker;
    }

    public function getResult()
    {
        $query = StockDataDaily
            ::where('stock_ticker_id', $this->stockTicker->id);

        $query = $this->modifyQueryByTimeFrame($query);

        $result = $query
            ->get();

        $tickerData = $result->first();

        if (is_null($tickerData)) {
            return 0;
        }

        $column = $this->getColumn();
        return $tickerData->{$column};
    }

    private function getColumn(): string
    {
        if ($this->modifier['type'] === StockAttributeEnum::OPEN) {
            return 'open';
        }

        if ($this->modifier['type'] === StockAttributeEnum::CLOSE) {
            return 'close';
        }

        if ($this->modifier['type'] === StockAttributeEnum::HIGH) {
            return 'high';
        }

        return 'low';
    }

    private function modifyQueryByTimeFrame($query)
    {
        if ($this->modifier['timeFrame'] === 'latest') {
            $startOfNDaysAgo = Carbon::now()->subDays(1)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays(1)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        if ($this->modifier['timeFrame'] === '-1d') {
            $startOfNDaysAgo = Carbon::now()->subDays(1)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays(1)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        if ($this->modifier['timeFrame'] === '-nd') {
            $nDaysAgo = (int) $this->modifier['number'];
            $startOfNDaysAgo = Carbon::now()->subDays($nDaysAgo)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays($nDaysAgo)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        return $query;
    }
}
