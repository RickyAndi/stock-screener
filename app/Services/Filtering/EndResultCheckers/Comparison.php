<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Interfaces\ResultInterface;

abstract class Comparison
{
    abstract protected function compare(ResultInterface $resultOne, ResultInterface $resultTwo): bool;

    public function check(ResultInterface $resultOne, ResultInterface $resultTwo)
    {
        return $this->compare($resultOne, $resultTwo);
    }
}
