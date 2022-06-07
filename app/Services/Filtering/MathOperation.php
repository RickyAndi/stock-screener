<?php

namespace App\Services\Filtering;

use App\Services\Filtering\Enums\MathOperationEnum;
use App\Services\Filtering\Interfaces\ResultInterface;

class MathOperation implements ResultInterface
{
    private $modifier;
    private $resultOne;
    private $resultTwo;

    public function __construct(
        Modifier $modifier, 
        ResultInterface $resultOne, 
        ResultInterface $resultTwo
    )
    {
        $this->modifier = $modifier;
        $this->resultOne = $resultOne;
        $this->resultTwo = $resultTwo;    
    }

    private function plus($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() + $toBeOperatedTwo->getResult();
    }

    private function minus($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() - $toBeOperatedTwo->getResult();
    }

    private function divide($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() / $toBeOperatedTwo->getResult();
    }

    private function time($toBeOperatedOne, $toBeOperatedTwo)
    {
        return $toBeOperatedOne->getResult() * $toBeOperatedTwo->getResult();
    }

    public function getResult()
    {
        return $this->operate($this->resultOne, $this->resultTwo);
    }

    public function getType(): string
    {
        return $this->modifier['type'];
    }

    public function operate($toBeOperatedOne, $toBeOperatedTwo)
    {
        if ($this->modifier->type === MathOperationEnum::PLUS) {
            return $this->plus($this->resultOne, $this->resultTwo);
        }

        if ($this->modifier->type === MathOperationEnum::MINUS) {
            return $this->minus($this->resultOne, $this->resultTwo);
        }

        if ($this->modifier->type === MathOperationEnum::TIME) {
            return $this->time($this->resultOne, $this->resultTwo);
        }

        return $this->divide($this->resultOne, $this->resultTwo);
    }
}
