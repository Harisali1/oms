<?php

namespace App\Models;

use App\Models\Interfaces\JoeysZoneScheduleInterface;
use App\Models\Interfaces\SprintInterface;

use App\Models\Interfaces\SprintTaskInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class JoeysZoneSchedule extends Model implements JoeysZoneScheduleInterface
{

    public $table = 'joeys_zone_schedule';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','joey_id','zone_schedule_id','start_time','end_time', 'wage','joeyco_notes',
        'joey_notes','bonus_type', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $with = ['schedule','joey'];



    public function schedule()
    {
        return $this->belongsTo(ZoneSchedule::class, 'zone_schedule_id', 'id');
    }

    public function joey()
    {
        return $this->belongsTo(Joey::class);
    }





}
