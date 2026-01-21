<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [
        'id'
    ];


    public function sub()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function categoryuser() {
        return $this->hasMany(CategoryUser::class);
    }

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

}
