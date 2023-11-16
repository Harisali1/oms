<?php

namespace App\Models;

use App\Models\Interfaces\ZoneRoutingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ZoneRouting extends Model implements ZoneRoutingInterface
{
    use SoftDeletes;

    public $table = 'zones_routing';

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
        return $this->hasMany(SlotsPostalCode::class, 'zone_id', 'id');
    }

    public function orderCategory()
    {
        return $this->belongsToMany(OrderCategory::class);
    }



}