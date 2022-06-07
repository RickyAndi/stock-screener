<?php

namespace App\Services\Filtering;

use App\Services\Filtering\Modifier;
use App\Services\Filtering\Interfaces\ResultInterface;

class Number implements ResultInterface
{
    const TYPE = 'Number';
    
    private $modifier;

    public function __construct(Modifier $modifier)
    {
        $this->modifier = $modifier;
    }

    public function getResult()
    {
        return (int) $this->modifier->data['number'];
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
