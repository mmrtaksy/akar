<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $guarded = [
        'id'
    ];

    public function category() {
        return $this->hasOne(BlogCategory::class, 'id', 'blog_category_id');
    }


    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->slug = Str::slug($model->title);
    //     });

    //     static::updating(function ($model) {
    //         $model->slug = Str::slug($model->title);
    //     });
    // }


}
