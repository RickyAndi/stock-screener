<?php

namespace App\Services\Filtering\Enums;

class EndResultCheckersEnum
{
    const LIST = [
        CrossEnum::CROSSED_ABOVE,
        CrossEnum::CROSSED_BELOW,
        ComparisonEnum::EQUALS,
        ComparisonEnum::NOT_EQUALS,
        ComparisonEnum::GREATER_THAN,
        ComparisonEnum::GREATER_THAN_EQUAL_TO,
        ComparisonEnum::LESSER_THAN,
        ComparisonEnum::LESSER_THAN_EQUAL_TO
    ];
}
