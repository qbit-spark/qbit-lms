<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockTake extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_take_date',
        'conducted_by',
        'notes',
        'status'
    ];

    protected $casts = [
        'stock_take_date' => 'date'
    ];

    public function conductor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(StockTakeItem::class);
    }

    public function initializeItems()
    {
        $books = book::all();
        
        foreach ($books as $book) {
            $this->items()->create([
                'book_id' => $book->id,
                'system_quantity' => $book->current_stock,
            ]);
        }
    }

    public function updateStock()
    {
        if ($this->status !== 'completed') {
            throw new \Exception('Cannot update stock for incomplete stock take.');
        }

        foreach ($this->items as $item) {
            $book = $item->book;
            if ($item->counted_quantity !== null) {
                $book->current_stock = $item->counted_quantity;
                $book->save();
            }
        }
    }
}