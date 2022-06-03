<?php

namespace App\Services\Filtering\Enums;

class StockAttributeEnum
{
    const OPEN = 'Open';
    const CLOSE = 'Close';
    const HIGH = 'High';
    const LOW = 'Low';

    const LIST = [
        self::OPEN,
        self::CLOSE,
        self::HIGH,
        self::LOW
    ];
}
