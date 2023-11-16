<?php

namespace App\Models;


use App\Models\Interfaces\SprintConfirmationInterface;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class JoeyLocation extends Model
{
//    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'joey_locations';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}
