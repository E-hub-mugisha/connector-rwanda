<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'service_id',
        'title',
        'description',
        'discount',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'discount'  => 'decimal:2',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(
            Service::class,
            'service_id',
            'id'
        );
    }
}