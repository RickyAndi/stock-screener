<?php

namespace App\Services\Filtering\Interfaces;

interface ResultInterface
{
    public function getResult();

    public function getType(): string;
}
