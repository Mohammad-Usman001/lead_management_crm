<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReplacement extends Model
{
    protected $fillable = [
        'client_name',
        'deposited_by',
        'deposit_date',
        'items',
        'quantity',
        'replacement_date',
        'status',
        'remarks',
    ];
    protected $casts = [
        'items' => 'array', // 👈 auto JSON decode
    ];
}
