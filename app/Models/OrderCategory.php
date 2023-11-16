<?php

namespace App\Models;


use App\Models\Interfaces\OrderCategoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderCategory extends Model implements OrderCategoryInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'order_category';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function trainings()
    {
        return $this->hasMany(Trainings::class, 'order_category_id','id');
    }

    public function deliveryType()
    {
        return $this->belongsToMany(DeliveryType::class);
    }

    public function deliveryPreference()
    {
        return $this->belongsToMany(DeliveryPreference::class);
    }

    public function orderCategoryZone()
    {
        return $this->belongsToMany(ZoneRouting::class,'order_category_zone');
    }

    public function orderZone()
    {
        return $this->hasOne(OrderZone::class);
    }



}