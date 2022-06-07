<?php

namespace App\Services\Filtering\EndResultCheckers;

use Exception;
use App\Services\Filtering\Interfaces\ResultInterface;

abstract class Comparison
{
    abstract protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool;

    public function check(ResultInterface $resultOne, ResultInterface $resultTwo)
    {
        if (is_array($resultOne->getResult()) || is_array($resultTwo->getResult())) {
            throw new Exception('Array cannot be equally compared');
        }

        return $this->compare($resultOne, $resultTwo);
    }
}
