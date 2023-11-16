<?php

namespace App\Models;

use App\Models\Interfaces\HubInterface;
use Illuminate\Database\Eloquent\Model;


class Hub extends Model implements HubInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'hubs';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];




}