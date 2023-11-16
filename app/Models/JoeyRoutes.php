<?php

namespace App\Models;

use App\Models\Interfaces\JoeyRoutesInterface;
use Illuminate\Database\Eloquent\Model;


class JoeyRoutes extends Model implements JoeyRoutesInterface
{

    public $table = 'joey_routes';

    protected $guarded = [];

    public function Hub()
    {
        return $this->hasOne(Hub::class, 'id', 'hub');
    }

    public function Zones()
    {
        return $this->hasOne(ZoneRouting::class, 'id', 'zones');
    }

    public function joeyRouteLocation()
    {
        return $this->hasMany(JoeyRouteLocation::class,'route_id','id')->whereNull('deleted_at');
    }

    public function joey(){
        return $this->belongsTo(Joey::class,'joey_id','id');
    }

}
