<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $casts = [
        'approved' => 'boolean',
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
