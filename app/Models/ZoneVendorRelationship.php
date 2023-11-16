<?php

namespace App\Models;

use App\Models\Interfaces\ZoneVendorRelationShipInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ZoneVendorRelationship extends Model implements ZoneVendorRelationShipInterface
{

    public $table = 'zone_vendor_relationship';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vendor_id', 'zone_id'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zones::class);
    }

}


