<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Interfaces\ResultInterface;

class NotEqual extends Comparison
{
    protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool
    {
        return $resultOne->getResult() != $resultTwo->getResult();
    }
}
