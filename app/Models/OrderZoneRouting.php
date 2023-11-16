<?php

namespace App\Models;

use App\Models\Interfaces\OrderZoneRoutingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderZoneRouting extends Model implements OrderZoneRoutingInterface
{
    use SoftDeletes;

    protected $fillable = [
        'hub_id',
        'zone_type_id',
        'title',
        'address',
        'is_custom_routing',
    ];

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function zoneType()
    {
        return $this->belongsTo(ZonesType::class);
    }

    public function postalCode()
    {
        return $this->hasMany(OrderPostalCode::class, 'zone_id', 'id');
    }

    public function orderCategory()
    {
        return $this->belongsToMany(OrderCategory::class);
    }

}
