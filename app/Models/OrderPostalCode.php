<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPostalCode extends Model
{
    protected $fillable = [
        'zone_id',
        'postal_code'
    ];

    public function zone()
    {
        return $this->belongsTo(OrderZoneRouting::class);
    }
}
