<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'inclusion',
        'exclusion',
        'service_category_id',
        'sub_category_id',
        'service_provider_id',
        'price',
        'discount',
        'discount_type',
        'location',
        'duration',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Category
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
    | Subcategory
    |--------------------------------------------------------------------------
    */

    public function subcategory()
    {
        return $this->belongsTo(
            ServiceSubCategory::class,
            'sub_category_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Service Provider
    |--------------------------------------------------------------------------
    */

    public function provider()
    {
        return $this->belongsTo(
            ServiceProvider::class,
            'service_provider_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Optional alias
    |--------------------------------------------------------------------------
    |
    | This keeps old Blade code such as $service->sprovider working.
    | Prefer $service->provider going forward.
    |
    */

    public function sprovider()
    {
        return $this->provider();
    }

    /*
    |--------------------------------------------------------------------------
    | Ratings
    |--------------------------------------------------------------------------
    */

    public function ratings()
    {
        return $this->hasMany(
            ServiceRating::class,
            'service_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Bookings
    |--------------------------------------------------------------------------
    */

    public function serviceBookings()
    {
        return $this->hasMany(
            ServiceBooking::class,
            'service_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Media
    |--------------------------------------------------------------------------
    */

    public function media()
    {
        return $this->hasMany(
            ServiceMedia::class,
            'service_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Portfolios
    |--------------------------------------------------------------------------
    */

    public function portfolios()
    {
        return $this->hasMany(
            Portfolio::class,
            'service_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Staff
    |--------------------------------------------------------------------------
    */

    public function staffMembers()
    {
        return $this->belongsToMany(
            StaffMember::class,
            'service_staff',
            'service_id',
            'staff_member_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Promotions
    |--------------------------------------------------------------------------
    */

    public function promotions()
    {
        return $this->hasMany(
            Promotion::class,
            'service_id',
            'id'
        );
    }
}
