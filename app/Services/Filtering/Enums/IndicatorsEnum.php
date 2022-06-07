<?php

namespace App\Services\Filtering\Enums;

class IndicatorsEnum
{
    const UPPER_BOLLINGER_BAND = 'UpperBollingerBand';
    const LOWER_BOLLINGER_BAND = 'LowerBollingerBand';
    const VWAP = 'VWAP';

    const LIST = [
        self::UPPER_BOLLINGER_BAND,
        self::LOWER_BOLLINGER_BAND
    ];
}
