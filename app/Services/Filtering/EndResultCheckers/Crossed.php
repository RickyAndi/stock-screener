<?php

namespace App\Services\Filtering\EndResultCheckers;

use Exception;
use App\Services\Filtering\Interfaces\ResultInterface;
use Illuminate\Support\Facades\Log;

abstract class Crossed
{
    abstract protected function compare($valueOne, $valueTwo): bool;

    public function check(ResultInterface $resultOne, ResultInterface $resultTwo)
    {
        if (!is_array($resultOne->getResult())) {
            throw new Exception("The result of first parameter must be an array");
        }

        $toBeCrossed = $resultTwo->getResult();
        if (!is_array($toBeCrossed)) {
            $toBeCrossedSingleValue = $toBeCrossed;
            $toBeCrossed = [];
            for ($index = 0; $index <= (count($resultOne->getResult()) - 1); $index++) {
                $toBeCrossed[] = $toBeCrossedSingleValue;
            }
        }
        
        $checkingIfValueWasCrossing = [];
        $arraifiedResultOne = $resultOne->getResult();

        for ($comparingIndex = 0; $comparingIndex <= (count($resultOne->getResult()) - 1); $comparingIndex++) {
            $checkingIfValueWasCrossing[] = $this->compare($arraifiedResultOne[$comparingIndex], $toBeCrossed[$comparingIndex]); 
        }

        $crossed = false;
        $noChangeTillEnd = true;

        foreach ($checkingIfValueWasCrossing as $wasValueCrossing) {
            if (!$wasValueCrossing) {
                $crossed = true;
            }

            if ($crossed) {
                if ($wasValueCrossing) {
                    $noChangeTillEnd = false;
                }
            }
        }

        return $crossed && $noChangeTillEnd;
    }
}
