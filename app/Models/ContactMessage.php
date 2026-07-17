<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'company_name',
        'location',
        'email',
        'subject',
        'phone',
        'message',
        'reply_text',
        'replied_at',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}