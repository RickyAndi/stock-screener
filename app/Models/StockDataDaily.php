<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDataDaily extends Model
{
    protected $table = 'stock_data_daily';

    protected $fillable = [
        'open',
        'close',
        'high',
        'low',
        'volume',
        'stock_ticker_id',
        'time'
    ];

    protected $casts = [
        'time' => 'datetime'
    ];

    public function stockTicker()
    {
        return $this->belongsTo(StockTicker::class, 'stock_ticker_id');
    }
}
