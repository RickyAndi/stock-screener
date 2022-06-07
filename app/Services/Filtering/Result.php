<?php

namespace App\Services\Filtering;

class Result
{
    private $type;
    private $value;

    public function __construct(string $type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getResult()
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
