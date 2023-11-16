<?php

namespace App\Models;

use App\Models\Interfaces\JoeyRoutificJobRouteInterface;
use Illuminate\Database\Eloquent\Model;

class JoeyRoutificJobRoute extends Model implements JoeyRoutificJobRouteInterface
{
    protected $fillable = [
        'joey_id',
        'job_id'
    ];

    public function joey()
    {
        return $this->belongsTo(Joey::class);
    }

    public function job()
    {
        return $this->belongsTo(JoeyRoutificJob::class, 'job_id', 'id');
    }

    public function location()
    {
        return $this->hasMany(JoeyRoutificJobLocation::class, 'route_id', 'id');
    }
}
