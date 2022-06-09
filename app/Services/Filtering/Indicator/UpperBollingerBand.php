<?php

namespace App\Services\Filtering\Indicator;

use Exception;
use App\Models\StockDataDaily;
use Illuminate\Support\Carbon;
use App\Services\Filtering\Modifier;
use App\Services\Filtering\Enums\IndicatorsEnum;
use App\Services\Filtering\Enums\TimeWindowEnum;
use App\Services\Filtering\Interfaces\ResultInterface;
use Illuminate\Support\Facades\Log;

class UpperBollingerBand implements ResultInterface
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
            $standardDeviation = (float) $this->modifier->data['standardDeviation'];

            $converted = $closePrices
                ->pluck('close')
                ->map(function ($value) {
                    return (float) $value;
                })
                ->all();
            
            Log::info("moving average");
            Log::info(trader_ma($converted, 20, TRADER_MA_TYPE_SMA));

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

            $arraifiedResult = collect($result[0])->values()->toArray();
            
            Log::info("Upper bollinger band");
            Log::info(json_encode($arraifiedResult));

            return $arraifiedResult;

        } catch (Exception $exception) {
            
            Log::info($this->modifier->stockTicker->symbol);
            Log::error($exception->getMessage());

            return [];
        }
    }

    public function getType(): string
    {
        return IndicatorsEnum::UPPER_BOLLINGER_BAND;
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
            $number = (int) $this->modifier->data['number'];
            $maPeriode = (int) $this->modifier->data['movingAveragePeriod'];
            
            Log::info($number);
            Log::info($maPeriode);

            $toDate = Carbon
                ::now()
                ->subDays($number)
                ->startOfDay();
            $fromDate = Carbon
                ::now()
                ->subDays($number)
                ->subDays($maPeriode + 50)
                ->startOfDay();
            
            Log::info($fromDate);
            Log::info($toDate);

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
