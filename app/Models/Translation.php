<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    protected $table = 'translations';
    protected $guarded = [
        'id'
    ];

    public function languages(): BelongsTo
    {
        return $this->belongsTo(Languages::class);
    }
}
