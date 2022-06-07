<?php

namespace App\Services\Filtering\Indicator;

use App\Models\StockDataDaily;
use App\Services\Filtering\Enums\IndicatorsEnum;
use App\Services\Filtering\Enums\TimeWindowEnum;
use App\Services\Filtering\Interfaces\ResultInterface;
use App\Services\Filtering\Modifier;
use Exception;
use Illuminate\Support\Carbon;

class LowerBollingerBand implements ResultInterface
{
    private $modifier;

    public function __construct(Modifier $modifier)
    {
        $this->modifier = $modifier;
    }

    public function getResult()
    {
        $query = $this->getRootQuery();

        $dateQuery = $this->getQueryDate();

        $closePrices = $query
            ->select('close')
            ->where('time', '>', $dateQuery->format('Y-m-d H:i:s'))
            ->where('stock_ticker_id', $this->modifier->stockTicker->id)
            ->get();

        $timePeriod = (int) $this->modifier->data['movingAveragePeriod'];
        $standardDeviation = $this->modifier->data['standardDeviation'];

        $result = trader_bbands(
            $closePrices->pluck('close')->all(),
            $timePeriod,
            $standardDeviation,
            $standardDeviation,
            TRADER_MA_TYPE_SMA
        );

        if (is_bool($result)) {
            throw new Exception("There was error getting bband data");
        }

        return collect($result[2])->values()->toArray() ?? [];
    }

    public function getType(): string
    {
        return IndicatorsEnum::LOWER_BOLLINGER_BAND;
    }

    private function getQueryDate()
    {
        $now = Carbon::now();

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::WITHIN_N_DAYS_AGO) {
            $number = $this->modifier->data['number'];
            $date = $now->subDays($number)->startOfDay();
            return $date;
        }

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::LATEST) {
            $number = $this->modifier->data['number'];
            $date = $now->startOfDay();
            return $date;
        }

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::ONE_DAY_AGO) {
            $number = $this->modifier->data['number'];
            $date = $now->subDays(1)->startOfDay();
            return $date;
        } 
    }

    private function getRootQuery()
    {
        return StockDataDaily::query();
    }
}
