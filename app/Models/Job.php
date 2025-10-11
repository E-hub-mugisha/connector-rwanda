<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'requirements',
        'responsibilities',
        'company_id',
        'deadline',
        'status',

    ];
    public function company()
    {
        return $this->belongsTo(ServiceProvider::class, 'company_id');
    }

    protected $casts = [
        'deadline' => 'date',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
