<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    public function services()
    {
        return $this->hasMany(
            Service::class,
            'service_category_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Subcategories
    |--------------------------------------------------------------------------
    */

    public function subcategories()
    {
        return $this->hasMany(
            ServiceSubCategory::class,
            'service_category_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Parent Category
    |--------------------------------------------------------------------------
    |
    | Keep only if your categories table actually has
    | service_category_id as a parent-category column.
    |
    */

    public function parent()
    {
        return $this->belongsTo(
            ServiceCategory::class,
            'service_category_id',
            'id'
        );
    }

    public function blogs()
    {
        return $this->hasMany(
            Blogs::class,
            'service_category_id'
        );
    }
}
