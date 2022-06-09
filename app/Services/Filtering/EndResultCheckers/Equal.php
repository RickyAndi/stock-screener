<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Interfaces\ResultInterface;
use Exception;

class Equal extends Comparison
{
    protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool
    {
        $resultOne = $resultOne->getResult();
        $resultTwo = $resultTwo->getResult();

        if (is_array($resultOne) && is_array($resultTwo)) {
            $results = [];
            foreach ($resultOne as $index => $value) {
                $results[] = $value == $resultTwo[$index] ?? 0;
            }

            return collect($results)->every(function ($isEqual, $key) {
                return $isEqual;
            });
        }

        if (is_array($resultOne) && !is_array($resultTwo)) {
            $results = [];
            foreach ($resultOne as $resultOneValue) {
                $results[] = $resultOneValue == $resultTwo;
            }

            return collect($results)->every(function ($isEqual, $key) {
                return $isEqual;
            });
        }

        if (!is_array($resultOne) && is_array($resultTwo)) {
            $results = [];
            foreach ($resultTwo as $resultTwoValue) {
                $results[] = $resultTwoValue === $resultOne;
            }

            return collect($results)->every(function ($isEqual, $key) {
                return $isEqual;
            });
        }

        return $resultOne->getResult() === $resultTwo->getResult();
    }
}
