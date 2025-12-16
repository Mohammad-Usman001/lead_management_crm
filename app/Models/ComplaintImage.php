<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplaintImage extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'path', 'original_name'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
