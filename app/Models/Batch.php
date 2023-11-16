<?php

namespace App\Models;

use App\Models\Interfaces\batchInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Batch extends Model implements batchInterface
{
    use SoftDeletes;
    public $table = 'betch';

    protected $guarded = [];

    public function joeys()
    {
        return $this->belongsTo(Joey::class, 'joey_id', 'id');
    }

    public function VendorName()
    {
        return $this->belongsTo(Vendor::class, 'store_num', 'id');
    }

    public function batchOrders()

    {
        return $this->belongsTo(BatchOrder::class, 'id', 'betch_id');
    }

    public function getlocation($locationId)

    {
        $location = Location::find($locationId);
        return $location->address . ', ' . $location->city->name .' , '. $location->postal_code;
    }
  public function getContact($Contact_id)

    {
        $dropoffname = SprintContacts::find($Contact_id);
        return $dropoffname->name;
    }

    public function order_id()
    {
        return $this->belongsTo(BatchOrder::class, 'id', 'betch_id')->get('order_id');
    }

}
