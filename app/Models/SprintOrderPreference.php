<?php

namespace App\Models;

use App\Models\Interfaces\SprintOrderPreferencesInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;

class SprintOrderPreference extends Model implements SprintOrderPreferencesInterface

{

public $table = 'sprint__order_preferences';

use Notifiable;

/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'id','sprint_id','type','time'
];

/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];

/**
* The attributes that should be cast to native types.
*
* @var array
*/
protected $casts = [
];

}
?>
