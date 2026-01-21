<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $guarded = [
        'id'
    ];

    public function translations()
    {
        return $this->hasMany(Translation::class, 'languages_id' ,'id');
    }
}
