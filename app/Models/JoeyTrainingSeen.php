<?php

namespace App\Models;

use App\Models\Interfaces\JoeyTrainingSeenInterface;
use Illuminate\Database\Eloquent\Model;


class JoeyTrainingSeen extends Model implements JoeyTrainingSeenInterface
{

    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'joey_training_seen';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];




}