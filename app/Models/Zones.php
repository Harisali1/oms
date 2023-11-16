<?php

namespace App\Models;

use App\Models\Interfaces\ZonesInterface;
use Illuminate\Database\Eloquent\Model;


class Zones extends Model implements ZonesInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'zones';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function zoneSchedule()
    {
        return $this->hasMany(ZoneSchedule::class, 'zone_id', 'id');
    }





}