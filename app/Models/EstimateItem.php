<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateItem extends Model
{
    protected $fillable = ['estimate_id','line','description','qty','rate','amount'];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
