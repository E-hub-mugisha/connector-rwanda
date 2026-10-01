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
        'service_provider_id',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(
            ServiceProvider::class,
            'service_provider_id',
            'id'
        );
    }

    public function applications()
    {
        return $this->hasMany(
            JobApplication::class,
            'job_id',
            'id'
        );
    }
}