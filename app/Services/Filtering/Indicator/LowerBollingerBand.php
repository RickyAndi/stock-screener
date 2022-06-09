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
        try {
            $query = $this->getRootQuery();

            $query = $query
                ->select('close')
                ->where('stock_ticker_id', $this->modifier->stockTicker->id);

            $query = $this->modifyQueryByDate($query);

            $closePrices = $query
                ->orderBy('time', 'DESC')
                ->get();

            $timePeriod = (int) $this->modifier->data['movingAveragePeriod'];
            $standardDeviation = $this->modifier->data['standardDeviation'];

            $converted = $closePrices->pluck('close')->map(function ($value) {
                return (float) $value;
            })->all();
            Log::info(json_encode($converted));
            $result = trader_bbands(
                $converted,
                $timePeriod,
                $standardDeviation,
                $standardDeviation,
                TRADER_MA_TYPE_SMA
            );

            if (is_bool($result)) {
                throw new Exception("There was error getting bband data");
            }

            return collect($result[2])->values()->toArray() ?? [];

        } catch (Exception $exception) {
            
            return [];
        }
    }

    public function getType(): string
    {
        return IndicatorsEnum::LOWER_BOLLINGER_BAND;
    }

    private function modifyQueryByDate($query)
    {
        $now = Carbon::now();

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::WITHIN_N_DAYS_AGO) {
            $number = $this->modifier->data['number'];
            $date = $now->subDays($number)->startOfDay();
            return $query
                ->where('time', '>', $date->format('Y-m-d H:i:s'));
        }

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::LATEST) {
            $number = $this->modifier->data['number'];
            $date = $now->startOfDay();
            return $query
                ->where('time', '>', $date->format('Y-m-d H:i:s'));
        }

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::ONE_DAY_AGO) {
            $number = $this->modifier->data['number'];
            $date = $now->subDay()->startOfDay();
            return $query
                ->where('time', '>', $date->format('Y-m-d H:i:s'));
        }

        if ($this->modifier->data['timeWindow'] === TimeWindowEnum::N_DAYS_AGO) {
            $number = $this->modifier->data['number'];
            $maPeriode = $this->modifier->data['movingAveragePeriod'];
            $toDate = Carbon
                ::now()
                ->subDays($number)
                ->startOfDay();
            $fromDate = Carbon
                ::now()
                ->subDays($number)
                ->subDays($maPeriode)
                ->startOfDay();

            return $query
                ->where('time', '>=', $fromDate->format('Y-m-d H:i:s'))
                ->where('time', '<=', $toDate->format('Y-m-d H:i:s'));
        }
    }

    private function getRootQuery()
    {
        return StockDataDaily::query();
    }
}
