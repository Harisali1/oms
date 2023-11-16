<?php

namespace App\Models;


use App\Models\Interfaces\SprintConfirmationInterface;
use Illuminate\Database\Eloquent\Model;


class SprintConfirmation extends Model implements SprintConfirmationInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'sprint__confirmations';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}