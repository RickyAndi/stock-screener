<?php

namespace App\Services\Filtering;

use App\Models\StockTicker;
use Exception;

class Modifier
{
    public $stockTicker;
    public $type;
    public $data;

    public function __construct(StockTicker $stockTicker, string $type, array $data)
    {
        $this->stockTicker = $stockTicker;
        $this->type = $type;
        $this->data = $data;
    }

    public static function fromArray(StockTicker $stockTicker, array $modifier): self
    {
        if (!isset($modifier['type'])) {
            throw new Exception('No type key found in modifier');
        }

        return new self($stockTicker, $modifier['type'], $modifier['data'] ?? []);
    }
}
