<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'service_category_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Parent Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            ServiceCategory::class,
            'service_category_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    public function services()
    {
        return $this->hasMany(
            Service::class,
            'service_sub_category_id',
            'id'
        );
    }

    public function blogs()
    {
        return $this->hasMany(
            Blogs::class,
            'service_sub_category_id'
        );
    }
}
