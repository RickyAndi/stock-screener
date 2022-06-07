<?php

namespace App\Services\Filtering;

use App\Models\StockDataDaily;
use App\Services\Filtering\Enums\StockAttributeEnum;
use App\Services\Filtering\Enums\TimeFrameEnum;
use App\Services\Filtering\Interfaces\ResultInterface;
use Illuminate\Support\Carbon;

class StockAttribute implements ResultInterface
{
    private $modifier;

    public function __construct(
        Modifier $modifier
    )
    {
        $this->modifier = $modifier;
    }

    private function getRootQuery()
    {
        if ($this->modifier->data['timeFrame'] === TimeFrameEnum::DAILY) {
            return StockDataDaily::query();
        }
    }

    public function getResult()
    {
        $rootQuery = $this->getRootQuery();

        $query = $rootQuery
            ->where('stock_ticker_id', $this->modifier->stockTicker->id);

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
        if ($this->modifier->type === StockAttributeEnum::OPEN) {
            return 'open';
        }

        if ($this->modifier->type === StockAttributeEnum::CLOSE) {
            return 'close';
        }

        if ($this->modifier->type === StockAttributeEnum::HIGH) {
            return 'high';
        }

        return 'low';
    }

    private function modifyQueryByTimeFrame($query)
    {
        if ($this->modifier->data['timeFrame'] === 'latest') {
            $startOfNDaysAgo = Carbon::now()->subDays(1)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays(1)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        if ($this->modifier->data['timeFrame'] === '-1d') {
            $startOfNDaysAgo = Carbon::now()->subDays(1)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays(1)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        if ($this->modifier->data['timeFrame'] === '-nd') {
            $nDaysAgo = (int) $this->modifier->data['number'];
            $startOfNDaysAgo = Carbon::now()->subDays($nDaysAgo)->startOfDay()->format('Y-m-d H:i:s'); 
            $endOfNDaysAgo = Carbon::now()->subDays($nDaysAgo)->addDay()->startOfDay()->format('Y-m-d H:i:s');

            return $query
                ->where('time', '>=', $startOfNDaysAgo)
                ->where('time', '<', $endOfNDaysAgo);
        }

        return $query;
    }

    public function getType(): string
    {
        return $this->modifier->type;
    }
}
