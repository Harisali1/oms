<?php

namespace App\Models;

use App\Models\Interfaces\TrainingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Trainings extends Model implements TrainingInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'trainings';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];




}