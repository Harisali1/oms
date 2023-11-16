<?php

namespace App\Models;

use App\Models\Interfaces\JoeyVehicleInterface;
use Illuminate\Database\Eloquent\Model;


class JoeyVehicle extends Model implements JoeyVehicleInterface
{

    public $table = 'joey_vehicles_detail';

    protected $guarded = [];



}