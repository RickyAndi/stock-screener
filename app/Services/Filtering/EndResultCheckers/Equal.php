<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Interfaces\ResultInterface;
use Exception;

class Equal extends Comparison
{
    protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool
    {
        return $resultOne->getResult() === $resultTwo->getResult();
    }
}
