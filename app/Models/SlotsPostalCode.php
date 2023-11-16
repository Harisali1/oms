<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotsPostalCode extends Model
{
    protected $fillable = [
        'zone_id',
        'postal_code'
    ];

    public function zone()
    {
        return $this->belongsTo(ZoneRouting::class);
    }
}
