<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterialLog extends Model
{
    protected $fillable = [
        'project_id',
        'technician_id',
        'item_name',
        'quantity',
        'entry_date',
        'remarks',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

   
}
