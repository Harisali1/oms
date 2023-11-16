<?php

namespace App\Models;

use App\Models\Interfaces\VendorInterface;
use Illuminate\Database\Eloquent\Model;


class Vendor extends Model implements VendorInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'vendors';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function getFullNameAttribute()
    {
        $full_name = $this->first_name.' '.$this->last_name;
        return ucfirst($full_name);
    }

    //get address of vendor "pickup address"
    public function vendorLocationId(){
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }


}
