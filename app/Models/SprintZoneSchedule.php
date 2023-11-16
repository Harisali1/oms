<?php

namespace App\Models;

use App\Models\Interfaces\SprintZoneScheduleInterface;
use Illuminate\Database\Eloquent\Model;

class SprintZoneSchedule extends Model implements SprintZoneScheduleInterface
{
    protected $table = 'sprint_zone_schedule';

    protected $fillable = [
        'sprint_id', 'zone_schedule_id', 'status'
    ];


    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function zoneSchedule()
    {
        return $this->belongsTo(ZoneSchedule::class);
    }

}
