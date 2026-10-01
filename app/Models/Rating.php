<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $casts = [
        'approved' => 'boolean',
        'rating' => 'integer',
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(
            ServiceProvider::class,
            'Service_Provider_ID',
            'id'
        );
    }
}