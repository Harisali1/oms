<?php

namespace App\Models;

use App\Models\Interfaces\SprintInterface;
use Illuminate\Database\Eloquent\Model;


class Sprint extends Model implements SprintInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'sprint__sprints';

    protected $guarded = [];

    public function Brand()
    {
        return $this->belongsTo(Brand::class,'creator_id','vendor_id');
    }

    /**
     * Get Joeys
     */
    public function Joeys()
    {
        return $this->belongsTo(Joey::class,'joey_id','id');
    }

    /**
     * Get Pickup Location
     */
    public function pickupLocation()
    {
        return $this->hasOne(Location::class, 'id', 'pickup_location_id');
    }

    /**
     * Get Dropoff Location
     */
    public function dropoffLocation()
    {
        return $this->hasOne(Location::class, 'id', 'dropoff_location_id');
    }

    /**
     * Get Vehicle
     */
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }

    /**
     * Get Sprint Task
     */
    public function SprintTasks()
    {
        return $this->hasMany( SprintTask::class,'sprint_id', 'id');
    }

    /**
     * Get last drop Sprint Task
     */
    public function LastDropOffTasks()
    {
        return $this->hasOne( SprintTask::class,'sprint_id', 'id')->orderBy('id','DESC')->where('type','dropoff');
    }

    /**
     * Relation With Vendor.
     *
     */
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class,'creator_id','id');
    }

    /**
     * Get Sprint Task
     */
    public function sprintZoneSchedule()
    {
        return $this->belongsToMany(ZoneSchedule::class);
    }


    /**
     * Get Dropoff Images
     */
    public function getDropoffImage()
    {
        return $this->hasOne(SprintConfirmation::class,'task_id','task_id')->whereNotNull('attachment_path')->select('attachment_path','created_at');
    }

    /**
     * Get Task History
     */
    public function getTaskHistory()
    {
        return $this->hasMany(SprintTaskHistory::class,'sprint_id','id')->whereNotIn('status_id',[38])->GroupBy('status_id','date')->select('id','sprint_id','sprint__tasks_id','status_id','date');
    }



}
