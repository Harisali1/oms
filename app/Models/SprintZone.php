<?php

namespace App\Models;
use App\Models\Interfaces\SprintZoneInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class SprintZone extends Model implements SprintZoneInterface
{

    public $table = 'sprint__sprint_zone';

    use SoftDeletes,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sprint_id', 'zone_id'
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zones::class);
    }
}
