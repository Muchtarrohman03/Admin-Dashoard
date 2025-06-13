<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'harga',
        'alt',
        'slug',
        'image',
        'stock',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->alt = $product->alt ?? $product->title;
            $product->slug = $product->slug ?? Str::slug($product->title);
        });

        static::updating(function ($product) {
            if ($product->isDirty('title')) {
                $product->alt = $product->title;
                $product->slug = Str::slug($product->title);
            }
        });
    }
    public function specification()
    {
        return $this->hasOne(Specification::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('kuantitas')->withTimestamps();
    }
    
}

