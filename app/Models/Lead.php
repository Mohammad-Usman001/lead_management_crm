<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'lead_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';


    // protected $fillable = [
    //     'received_date',
    //     'follow_up_date',
    //     'customer_name',
    //     'email',
    //     'country',
    //     'contact_number',
    //     'website',
    //     'lead_source',
    //     'service_required',
    //     'status',
    //     'linkedin_profile',
    //     'assigned_to',
    // ];
    protected $fillable = [
        'customer_name',
        'contact_number',
        'site_address',
        'city',
        'property_type',
        'site_area',
        'num_cameras',
        'camera_type',
        'features',
        'installation_required',
        'preferred_date',
        'budget',
        'lead_source',
        'status',
        'follow_up_date',
        'notes'
    ];
    protected $casts = [
        'features' => 'array',
        'preferred_date' => 'datetime',
        'follow_up_date' => 'datetime',
    ];
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the projects associated with this lead
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'linked_lead_id', 'lead_id');
    }
}
