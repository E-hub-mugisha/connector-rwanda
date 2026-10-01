<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    protected $fillable = [
        'tag',
        'image',
        'service_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}