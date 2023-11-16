<?php

namespace App\Models;

use App\Models\Interfaces\JoeyRoutificJobLocationInterface;
use Illuminate\Database\Eloquent\Model;

class JoeyRoutificJobLocation extends Model implements JoeyRoutificJobLocationInterface
{
    protected $fillable = [
        'route_id',
        'sprint_id',
        'location_name',
        'type',
        'arrival_time',
        'finish_time',
        'status'
    ];


    public function jobRoute()
    {
        return $this->belongsTo(JoeyRoutificJobRoute::class);
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
}
