<?php

namespace App\Models;

use App\Models\Interfaces\DeliveryTypeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExclusiveOrderJoey extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id','joey_id'
    ];

//    public function orderCategory()
//    {
//        return $this->belongsToMany(OrderCategory::class);
//    }
}
