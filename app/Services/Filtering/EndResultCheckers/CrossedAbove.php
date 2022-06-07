<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Interfaces\ResultInterface;
use Exception;

class CrossedAbove extends Crossed
{
    protected function compare($valueOne, $valueTwo): bool
    {
        return $valueOne < $valueTwo;
    }
}
