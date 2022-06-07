<?php

namespace App\Services\Filtering\EndResultCheckers;

use Exception;
use App\Services\Filtering\Interfaces\ResultInterface;

class CrossedBelow extends Crossed
{
    protected function compare($valueOne, $valueTwo): bool
    {
        return $valueOne > $valueTwo;
    }
}
