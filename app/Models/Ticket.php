<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets'; 
    protected $fillable = [
        'title',
        'description',
        'status',
        'date',
        'time',
        'customer_id',
        'instruction',
        'ai_response'
    ];
    // علاقة التذكرة بالعميل
    public function kunde()
    {
        return $this->belongsTo(\App\Models\Kunde::class, 'customer_id');
    }
}