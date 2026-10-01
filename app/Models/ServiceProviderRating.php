<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderRating extends Model
{
    use HasFactory;

    protected $table = 'service_provider_ratings';

    protected $fillable = [
        'user_id',
        'service_provider_id',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function serviceProvider()
    {
        return $this->belongsTo(
            ServiceProvider::class,
            'service_provider_id',
            'id'
        );
    }

    /*
     * Keep the old relationship name if
     * existing code already uses service_provider().
     */
    public function service_provider()
    {
        return $this->serviceProvider();
    }
}
