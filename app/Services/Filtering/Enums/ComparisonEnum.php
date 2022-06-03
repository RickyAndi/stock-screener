<?php

namespace App\Services\Filtering\Enums;

class ComparisonEnum
{
    const EQUALS = 'Equals';
    const NOT_EQUALS = 'NotEquals';
    const GREATER_THAN = 'GreaterThan';
    const GREATER_THAN_EQUAL_TO = 'GreaterThanEqualTo';
    const LESSER_THAN = 'LessThan';
    const LESSER_THAN_EQUAL_TO = 'LessThanEqualTo';

    const LIST = [
        self::EQUALS,
        self::NOT_EQUALS,
        self::GREATER_THAN,
        self::GREATER_THAN_EQUAL_TO,
        self::LESSER_THAN,
        self::LESSER_THAN_EQUAL_TO
    ];
}