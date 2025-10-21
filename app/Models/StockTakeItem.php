<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTakeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_take_id',
        'book_id',
        'system_quantity',
        'counted_quantity',
        'difference',
        'remarks'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->counted_quantity !== null) {
                $model->difference = $model->counted_quantity - $model->system_quantity;
            }
        });
    }

    public function stockTake(): BelongsTo
    {
        return $this->belongsTo(StockTake::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(book::class);
    }
}