<?php

namespace App\Models;

use App\Models\Interfaces\PreferWorkTimesInterface;
use Illuminate\Database\Eloquent\Model;


class PreferWorkTime extends Model implements PreferWorkTimesInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'prefer_work_times';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}