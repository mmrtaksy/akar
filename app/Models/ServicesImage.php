<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesImage extends Model
{
    use HasFactory;


    protected $table = 'services_image';
    protected $guarded = [
        'id'
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'id', 'service_id');
    }
}
