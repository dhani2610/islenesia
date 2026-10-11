<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_company',
        'client_country',
        'rating',
        'content',
        'avatar',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && (file_exists(public_path('storage/' . $this->avatar)) || file_exists(storage_path('app/public/' . $this->avatar)))) {
            return asset('storage/' . $this->avatar);
        }
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&background=0b1b3d&color=d4af37&bold=true';
    }
}
