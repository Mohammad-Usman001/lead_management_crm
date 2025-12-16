<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
     use HasFactory;

    protected $fillable = [
        'lead_id',
        'customer_name',
        'contact_number',
        'site_address',
        'city',
        'location_detail',
        'device_type',
        'serial_number',
        'issue_description',
        'priority',
        'status',
        'assigned_to',
        'reported_at',
        'scheduled_visit',
        'technician_notes'
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'scheduled_visit' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany(ComplaintImage::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
