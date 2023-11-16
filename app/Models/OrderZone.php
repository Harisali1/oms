<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderZone extends Model
{

    protected $fillable = [
        'order_category_id',
        'start_time',
        'end_time',
    ];

    public function category()
    {
        return $this->belongsTo(OrderCategory::class, 'order_category_id', 'id');
    }
}
