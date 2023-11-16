<?php

namespace App\Models;

use App\Models\Interfaces\DeliveryTypeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cancelOrder extends Model
{

    use SoftDeletes;

    protected $table = 'cancel_order';

    protected $fillable = [
        'sprint_id','reason'
    ];

//    public function orderCategory()
//    {
//        return $this->belongsToMany(OrderCategory::class);
//    }
}
