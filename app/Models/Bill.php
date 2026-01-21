<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';
    protected $guarded = [
        'id'
    ];


    public function country(){
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

    public function city(){
        return $this->hasOne(Cities::class, 'id', 'city_id');
    }


}
