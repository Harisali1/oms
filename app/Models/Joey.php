<?php

namespace App\Models;

use App\Models\Interfaces\JoeyInterface;
use Illuminate\Database\Eloquent\Model;


class Joey extends Model implements JoeyInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'joeys';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function getFullNameAttribute()
    {
        $full_name = $this->first_name.' '.$this->last_name;
        return ucfirst($full_name);
    }

    public function schedule()
    {
        return $this->hasMany(JoeysZoneSchedule::class);
    }


}