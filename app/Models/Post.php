<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'likes_count',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && (file_exists(public_path('storage/' . $this->image)) || file_exists(storage_path('app/public/' . $this->image)))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('images/blog/' . ($this->image ?: 'default-blog.jpg'));
    }
}
