<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use  HasFactory, Notifiable;

    protected $table = 'users';
    protected $guarded = [
        'id'
    ];


 


    public function getFullnameAttribute()
    {
        return $this->attributes['name'] . ' ' . $this->attributes['surname'];
    }
 

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }



    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $random = Str::random(40);
    //         $setslug = $model->name . ' ' . $model->surname . ' ' . $random;
    //         $model->slug = Str::slug($setslug, '-');
    //     });

    //     static::updating(function ($model) {
    //         $setslug = $model->name . ' ' . $model->surname . ' ' . $model->id;
    //         $model->slug = Str::slug($setslug, '-');
    //     });
    // }



}
