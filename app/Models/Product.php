<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'currency_id',
        'tax_cost',
        'manufacturing_cost'
    ];

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function prices() {
        return $this->hasMany(ProductPrice::class);
    }
}
