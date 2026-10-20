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
        if ($this->image && (file_exists(public_path('storage/' . $this->image)) || file_exists(storage_path('app/public/' . $this->image)))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('images/products/' . ($this->image ?: 'default-product.jpg'));
    }

    /**
     * Get processed gallery items with verified asset URLs.
     */
    public function getGalleryItemsAttribute(): array
    {
        if (empty($this->gallery) || !is_array($this->gallery)) {
            return [];
        }

        $items = [];
        foreach ($this->gallery as $index => $item) {
            $img = is_array($item) ? ($item['image'] ?? '') : $item;
            $title = is_array($item) ? ($item['title'] ?? '') : '';
            $caption = is_array($item) ? ($item['caption'] ?? '') : '';

            if (empty($img)) {
                continue;
            }

            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $url = $img;
            } elseif (file_exists(public_path('storage/' . $img)) || file_exists(storage_path('app/public/' . $img))) {
                $url = asset('storage/' . $img);
            } elseif (file_exists(public_path('images/products/gallery/' . basename($img)))) {
                $url = asset('images/products/gallery/' . basename($img));
            } elseif (file_exists(public_path('images/products/' . basename($img)))) {
                $url = asset('images/products/' . basename($img));
            } elseif (file_exists(public_path($img))) {
                $url = asset($img);
            } else {
                $url = asset('storage/' . $img);
            }

            $items[] = [
                'id' => $index + 1,
                'image' => $img,
                'image_url' => $url,
                'title' => $title ?: 'Foto Dokumentasi ' . ($index + 1),
                'caption' => $caption ?: '',
            ];
        }

        return $items;
    }
}
