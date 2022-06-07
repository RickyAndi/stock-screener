<?php

namespace App\Services\Filtering\EndResultCheckers;

use App\Services\Filtering\Enums\ComparisonEnum;
use App\Services\Filtering\Enums\CrossEnum;

class EndResultChecker
{
    const MAPPING = [
        ComparisonEnum::EQUALS => Equal::class,
        ComparisonEnum::NOT_EQUALS => NotEqual::class,
        ComparisonEnum::GREATER_THAN => GreaterThan::class,
        ComparisonEnum::GREATER_THAN_EQUAL_TO => GreaterThanEqualTo::class,
        ComparisonEnum::LESSER_THAN => LessThan::class,
        ComparisonEnum::LESSER_THAN_EQUAL_TO => LessThanEqualTo::class,
        CrossEnum::CROSSED_ABOVE => CrossedAbove::class,
        CrossEnum::CROSSED_BELOW => CrossedBelow::class
    ];

    public static function getEndResult(string $type)
    {
        $class = self::MAPPING[$type];
        return new $class();
    }
}
