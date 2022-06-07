<?php

namespace App\Services\Filtering\Indicator;

use App\Services\Filtering\Enums\IndicatorsEnum;
use App\Services\Filtering\Modifier;
use App\Services\Filtering\Interfaces\ResultInterface;

class BollingerBand implements ResultInterface
{
    const MAPPING = [
        IndicatorsEnum::UPPER_BOLLINGER_BAND => UpperBollingerBand::class,
        IndicatorsEnum::LOWER_BOLLINGER_BAND => LowerBollingerBand::class
    ];

    private $modifier;
    private $bollingerBand;

    public function __construct(Modifier $modifier)
    {
        $this->modifier = $modifier;

        $class = self::MAPPING[$modifier->type];
        $this->bollingerBand = new $class($modifier);
    }

    public function getResult()
    {
        return $this->bollingerBand->getResult();
    }

    public function getType(): string
    {
        return $this->bollingerBand->getType();
    }
}
