<?php

namespace App\Models;

use App\Models\Interfaces\ZoneScheduleInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class ZoneSchedule extends Model implements ZoneScheduleInterface

{

    use SoftDeletes;
    public $table = 'zone_schedule';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','zone_id','start_time','end_time',
        'occupancy','capacity','commission','hourly_rate',
        'vehicle_id','minimum_hourly_rate','notes','type',
        'is_display','deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_display' => 'boolean'
    ];



    public function zone()
    {
        return $this->belongsTo(Zones::class);
    }

    public function joeySchedule()
    {
        return $this->hasMany(JoeysZoneSchedule::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function sprintZoneSchedule()
    {
        return $this->belongsToMany(Sprint::class);
    }


}
