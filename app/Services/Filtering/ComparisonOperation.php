<?php

namespace App\Services\Filtering;

use App\Services\Filtering\Enums\ComparisonEnum;

class ComparisonOperation
{
    private $modifier;

    public function __construct(array $modifier)
    {
        $this->modifier = $modifier;
    }

    public function compare($toBeComparedOne, $toBeComparedTwo): bool
    {
        if ($this->modifier['type'] === ComparisonEnum::EQUALS) {
            return $this->equals($toBeComparedOne, $toBeComparedTwo);
        }

        if ($this->modifier['type'] === ComparisonEnum::NOT_EQUALS) {
            return $this->notEqual($toBeComparedOne, $toBeComparedTwo);
        }

        if ($this->modifier['type'] === ComparisonEnum::GREATER_THAN) {
            return $this->greaterThan($toBeComparedOne, $toBeComparedTwo);
        }

        if ($this->modifier['type'] === ComparisonEnum::GREATER_THAN_EQUAL_TO) {
            return $this->greaterThanEqualTo($toBeComparedOne, $toBeComparedTwo);
        }

        if ($this->modifier['type'] === ComparisonEnum::LESSER_THAN) {
            return $this->lessThan($toBeComparedOne, $toBeComparedTwo);
        }

        return $this->lessThanEqualTo($toBeComparedOne, $toBeComparedTwo);
    }

    public function equals($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() === $toBeComparedTwo->getResult();
    }

    public function notEqual($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() !== $toBeComparedTwo->getResult();
    }

    public function greaterThan($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() > $toBeComparedTwo->getResult();
    }

    public function greaterThanEqualTo($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() >= $toBeComparedTwo->getResult();
    }

    public function lessThan($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() < $toBeComparedTwo->getResult();
    }

    public function lessThanEqualTo($toBeComparedOne, $toBeComparedTwo): bool
    {
        return $toBeComparedOne->getResult() <= $toBeComparedTwo->getResult();
    }
}
