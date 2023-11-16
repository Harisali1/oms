<?php

namespace App\Models;

use App\Models\Interfaces\UserNotificationInterface;
use Illuminate\Database\Eloquent\Model;


class UserNotification extends Model implements UserNotificationInterface
{

    public $table = 'notifications';

    protected $guarded = [];

}
