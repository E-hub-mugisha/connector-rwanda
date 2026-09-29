<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'content', 'image', 'status', 'views', 'service_category_id', 'service_sub_category_id'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'service_sub_category_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class,'blog_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
