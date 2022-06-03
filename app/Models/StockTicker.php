<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTicker extends Model
{
    protected $table = 'stock_tickers';

    protected $fillable = [
        'name',
        'symbol'
    ];

    public function dailyData()
    {
        return $this->hasMany(
            StockDataDaily::class, 
            'stock_ticker_id'
        );
    }
}
