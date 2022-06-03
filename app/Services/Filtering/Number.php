<?php

namespace App\Services\Filtering;

class Number
{
    const TYPE = 'Number';
    
    private $modifier;

    public function __construct(array $modifier)
    {
        $this->modifier = $modifier;
    }

    public function getResult()
    {
        return (int) $this->modifier['number'];
    }
}
