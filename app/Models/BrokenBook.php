<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokenBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reported_by',
        'damage_type_id',
        'description',
        'damage_date',
        'status',
        'damaged_quantity',
        'repair_cost',
        'remarks',
        'deduct_status'
    ];

    public function book()
    {
        return $this->belongsTo(book::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function damageType()
    {
        return $this->belongsTo(DamageType::class);
    }
    
}
