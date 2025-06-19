<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'currency_id',
        'price'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}
