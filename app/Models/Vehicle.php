<?php
/**
 * Created by PhpStorm.
 * User: Joeyco-0031PK
 * Date: 11/3/2021
 * Time: 7:57 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [];

    public function zoneSchedule()
    {
        return $this->hasMany(ZoneSchedule::class);
    }
}