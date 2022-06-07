<?php

namespace App\Services\Filtering\Enums;

class TimeFrameEnum
{
    const DAILY = 'Daily';
    const WEEKLY = 'Weekly';
    const YEARLY = 'Yearly';
    
    const LIST = [
        self::DAILY,
        self::WEEKLY,
        self::YEARLY
    ];
}
