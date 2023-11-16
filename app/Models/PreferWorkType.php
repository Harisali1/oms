<?php

namespace App\Models;

use App\Models\Interfaces\PreferWorkTypesInterface;

use Illuminate\Database\Eloquent\Model;


class PreferWorkType extends Model implements PreferWorkTypesInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'prefer_work_type';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}