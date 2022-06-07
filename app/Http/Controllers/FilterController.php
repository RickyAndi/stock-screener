<?php

namespace App\Http\Controllers;

use App\Models\StockTicker;
use App\Services\Filtering\ComparisonOperation;
use App\Services\Filtering\EndResultCheckers\EndResultChecker;
use App\Services\Filtering\Enums\ComparisonEnum;
use App\Services\Filtering\Enums\EndResultCheckersEnum;
use App\Services\Filtering\Enums\IndicatorsEnum;
use App\Services\Filtering\Enums\MathOperationEnum;
use App\Services\Filtering\Enums\StockAttributeEnum;
use App\Services\Filtering\Indicator\BollingerBand;
use App\Services\Filtering\MathOperation;
use App\Services\Filtering\Modifier;
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

        Log::info($filteringQueries);

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
        $modifiers = $collectedQuery->map(function (array $modifier) use ($ticker) {
            return Modifier::fromArray($ticker, $modifier);
        });

        $indexOfComparison = null;
        foreach ($modifiers as $index => $modifier) {
            if (in_array($modifier->type, EndResultCheckersEnum::LIST)) {
                $indexOfComparison = $index;
                break;
            }
        }

        $leftSide = $modifiers->filter(function ($modifier, $index) use ($indexOfComparison) {
            return $index < $indexOfComparison;
        });

        $rightSide = $modifiers->filter(function ($modifier, $index) use ($indexOfComparison) {
            return $index > $indexOfComparison;
        });

        $resultOne = $this->processSide($leftSide, $ticker);
        $resultTwo = $this->processSide($rightSide, $ticker);

        $endResult = EndResultChecker::getEndResult($modifiers[$indexOfComparison]->type);
        return $endResult->check($resultOne, $resultTwo);
    }

    private function processSide(Collection $side, StockTicker $ticker)
    {
        $mathOperatorIndex = null;
        $resultOne = null;
        $resultTwo = null;

        $arraified = $side->reverse()->toArray();
        foreach ($arraified as $index => $modifier) {
            if (!is_null($resultOne) && !is_null($resultTwo)) {
                if (!is_null($mathOperatorIndex)) {
                    $resultOne = new MathOperation($arraified[$mathOperatorIndex], $resultOne, $resultTwo);
                    $resultTwo = null;
                }    
            }

            if (in_array($modifier->type, MathOperationEnum::LIST)) {
                $mathOperatorIndex = $index;
            }

            if ($modifier->type === Number::TYPE) {               
                if (is_null($resultOne)) {
                    $resultOne = new Number($modifier);
                }

                if (is_null($resultTwo)) {
                    $resultTwo = new Number($modifier);
                }
            }

            if (in_array($modifier->type, StockAttributeEnum::LIST)) {
                if (is_null($resultOne)) {
                    $resultOne = new StockAttribute($modifier);
                }

                if (is_null($resultTwo)) {
                    $resultTwo = new StockAttribute($modifier);
                }
            }

            if (in_array($modifier->type, StockAttributeEnum::LIST)) {
                if (is_null($resultOne)) {
                    $resultOne = new StockAttribute($modifier);
                }

                if (is_null($resultTwo)) {
                    $resultTwo = new StockAttribute($modifier);
                }
            }

            if (in_array($modifier->type, IndicatorsEnum::LIST)) {
                if (is_null($resultOne)) {
                    $resultOne = new BollingerBand($modifier);
                }

                if (is_null($resultTwo)) {
                    $resultTwo = new BollingerBand($modifier);
                }
            }
        }

        return $resultOne;
    }
}
