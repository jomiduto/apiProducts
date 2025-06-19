<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'exchange_rate'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function productPrice() {
        return $this->hasMany(ProductPrice::class);
    }
}
