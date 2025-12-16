<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'invoice_no','date','client_name','client_address','client_phone','email','gst','sub_total','total','notes'
    ];

    // protected $dates = ['date'];
    protected $casts = [
        'date' => 'date', // or 'datetime' if you store time too
        'sub_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(EstimateItem::class)->orderBy('line');
    }
}
