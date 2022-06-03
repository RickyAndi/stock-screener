<?php

namespace App\Services\Filtering;

class Result
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getResult()
    {
        return $this->value;
    }
}
