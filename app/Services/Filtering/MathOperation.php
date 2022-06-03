<?php

namespace App\Services\Filtering;

use App\Services\Filtering\Enums\MathOperationEnum;

class MathOperation
{
    private $modifier;

    public function __construct(array $modifier)
    {
        $this->modifier = $modifier;    
    }

    public function plus($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() + $toBeOperatedTwo->getResult();
    }

    public function minus($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() - $toBeOperatedTwo->getResult();
    }

    public function divide($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() / $toBeOperatedTwo->getResult();
    }

    public function time($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() * $toBeOperatedTwo->getResult();
    }

    public function operate($toBeOperatedOne, $toBeOperatedTwo)
    {
        if ($this->modifier['type'] === MathOperationEnum::PLUS) {
            return new Result($this->plus($toBeOperatedOne, $toBeOperatedTwo));
        }

        if ($this->modifier['type'] === MathOperationEnum::MINUS) {
            return new Result($this->minus($toBeOperatedOne, $toBeOperatedTwo));
        }

        if ($this->modifier['type'] === MathOperationEnum::TIME) {
            return new Result($this->time($toBeOperatedOne, $toBeOperatedTwo));
        }

        return new Result($this->divide($toBeOperatedOne, $toBeOperatedTwo));
    }
}
