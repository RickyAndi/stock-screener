<?php

namespace App\Services\Filtering\EndResultCheckers;

use Exception;
use App\Services\Filtering\Interfaces\ResultInterface;

class GreaterThan extends Comparison
{
    protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool
    {
        return $resultOne->getResult() > $resultTwo->getResult();
    }
}
