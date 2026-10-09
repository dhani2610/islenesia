<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'short_description',
        'description',
        'specifications',
        'image',
        'gallery',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'specifications' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('images/products/' . ($this->image ?: 'default-product.jpg'));
    }
}
