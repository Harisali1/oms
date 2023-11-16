<?php

namespace App\Models;

use App\Models\Interfaces\DeliveryTypeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryType extends Model implements DeliveryTypeInterface
{
    use SoftDeletes;
    protected $fillable = [
        'title','status','deleted_at'
    ];

    public function orderCategory()
    {
        return $this->belongsToMany(OrderCategory::class);
    }
}
