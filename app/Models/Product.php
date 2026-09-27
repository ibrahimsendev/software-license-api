<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function availableLicenses(): HasMany
    {
        return $this->hasMany(License::class)->whereNull('user_id');
    }
}
