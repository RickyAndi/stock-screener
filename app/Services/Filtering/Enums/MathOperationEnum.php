<?php

namespace App\Services\Filtering\Enums;

class MathOperationEnum
{
    const PLUS = 'Plus';
    const MINUS = 'Minus';
    const DIVIDE = 'Divide';
    const TIME= 'Time';

    const LIST = [
        self::MINUS,
        self::PLUS,
        self::DIVIDE,
        self::TIME
    ];
}
