<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelMenu extends Model
{

    protected $table = 'panel_menus';
    protected $guarded = [
        'id'
    ];

    protected $fillable = ['title', 'statu', 'meta', 'editor', 'multiple_image', 'image', 'categories', 'extra'];
    protected $casts = ['extra' => 'array', 'statu' => 'boolean', 'meta' => 'boolean', 'editor' => 'boolean', 'multiple_image' => 'boolean', 'image' => 'boolean', 'categories' => 'boolean'];
}
