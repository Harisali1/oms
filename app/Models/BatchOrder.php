<?php

namespace App\Models;

use App\Models\Interfaces\HubInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BatchOrder extends Model implements HubInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'betch_orders';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'id', 'order_id');
    }
//    public function dropoffAddress(){
//        return $this->belongsTo(Location::class , 'id' , 'location_id');
//    }
    public function dropoffLocation()
    {
        return $this->belongsTo(SprintTask::class, 'order_id', 'sprint_id')->where('type' , '=' ,'dropoff');
    }
public function BatchOrderid()
    {
        return $this->belongsTo(BatchOrder::class, 'betch_id', 'id');
    }

    public function getStatus()
    {
        return $this->hasMany(SprintTask::class, 'sprint_id', 'order_id')->whereIn('status_id', [61,24, 32, 67, 15, 68, 17,38]);
    }
    public function dropoffSprintId()
    {
        return $this->belongsTo(SprintTask::class, 'order_id', 'sprint_id')->where('type' , '=' , 'dropoff');
    }

}
