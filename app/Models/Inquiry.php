<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // 'buyer', 'petani', 'general'
        'name',
        'company',
        'whatsapp',
        'email',
        'subject',
        'message',
        'product_id',
        'status', // 'new', 'contacted', 'deal', 'closed'
        'ip_address',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
