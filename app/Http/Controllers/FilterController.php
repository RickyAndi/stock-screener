<?php

namespace App\Http\Controllers;

use App\Models\StockTicker;
use App\Services\Filtering\ComparisonOperation;
use App\Services\Filtering\Enums\ComparisonEnum;
use App\Services\Filtering\Enums\MathOperationEnum;
use App\Services\Filtering\Enums\StockAttributeEnum;
use App\Services\Filtering\MathOperation;
use App\Services\Filtering\Number;
use App\Services\Filtering\StockAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FilterController
{
    public function filter(Request $request)
    {
        $filteringQueries = $request->query('query');

        $resultContainer = collect([]);

        $tickers = StockTicker
            ::select('id', 'symbol')
            ->get();
        
        foreach ($tickers as $ticker) {
            $resultContainer[$ticker->symbol] = collect([]);
        }

        $parsedQueries = json_decode($filteringQueries, true);
        foreach ($tickers as $ticker) {
            foreach ($parsedQueries as $query) {
                $result = $this->runQuery($query, $ticker);
                $resultContainer[$ticker->symbol]->push($result); 
            }
        }

        $passedTickerSymbols = $resultContainer->filter(function ($checkResults, $tickerSymbol) {
            return $checkResults->every(function ($checkResult) {
                return $checkResult;
            });
        })->keys();
        
        $passedTickerModels = StockTicker
            ::whereIn('symbol', $passedTickerSymbols)
            ->get()
            ->map(function (StockTicker $stockTicker) {
                return [
                    'id' => $stockTicker->id,
                    'name' => $stockTicker->name,
                    'symbol' => $stockTicker->symbol,
                    'link' => route('ticker.detail', [
                        'ticker' => $stockTicker->symbol
                    ])
                ];
            });


        return response()
            ->json([
                'data' => $passedTickerModels
            ]); 
    }

    private function runQuery(array $query, StockTicker $ticker)
    {
        $collectedQuery = collect($query);

        $indexOfComparison = null;
        foreach ($collectedQuery as $index => $modifier) {
            if (in_array($modifier['type'], ComparisonEnum::LIST)) {
                $indexOfComparison = $index;
                break;
            }
        }

        $leftSide = $collectedQuery->filter(function ($modifier, $index) use ($indexOfComparison) {
            return $index < $indexOfComparison;
        });

        $rightSide = $collectedQuery->filter(function ($modifier, $index) use ($indexOfComparison) {
            return $index > $indexOfComparison;
        });

        $leftSideResult = $this->processSide($leftSide, $ticker);
        $rightSideResult = $this->processSide($rightSide, $ticker);

        $comparator = new ComparisonOperation($query[$indexOfComparison]);
        return $comparator->compare($leftSideResult, $rightSideResult);
    }

    private function processSide(Collection $side, StockTicker $ticker)
    {
        $mathOperator = null;
        $toBeOperatedOne = null;
        $toBeOperatedTwo = null;

        foreach ($side->reverse()->toArray() as $modifier) {
            if (in_array($modifier['type'], MathOperationEnum::LIST)) {
                $mathOperator = new MathOperation($modifier);
            }

            if ($modifier['type'] === Number::TYPE) {
                if (is_null($toBeOperatedTwo)) {
                    $toBeOperatedTwo = new Number($modifier);
                }

                if (is_null($toBeOperatedOne)) {
                    $toBeOperatedOne = new Number($modifier);
                }
            }

            if (in_array($modifier['type'], StockAttributeEnum::LIST)) {
                if (is_null($toBeOperatedTwo)) {
                    $toBeOperatedTwo = new StockAttribute($modifier, $ticker);
                }

                if (is_null($toBeOperatedOne)) {
                    $toBeOperatedOne = new StockAttribute($modifier, $ticker);
                }
            }

            if (!is_null($mathOperator) && !is_null($toBeOperatedOne) && !is_null($toBeOperatedTwo)) {
                $result = $mathOperator->operate($toBeOperatedOne, $toBeOperatedTwo);
                $toBeOperatedTwo = $result;
                $mathOperator = null;
                $toBeOperatedOne = null;
            }
        }

        return $toBeOperatedTwo;
    }
}
