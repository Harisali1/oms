<?php

namespace App\Models;

use App\Models\Interfaces\CityInterface;
use Illuminate\Database\Eloquent\Model;


class City extends Model implements CityInterface
{

    public $table = 'cities';

    protected $guarded = [];



}