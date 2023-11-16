<?php

namespace App\Models;


use App\Models\Interfaces\SprintTaskHistoryInterface;
use Illuminate\Database\Eloquent\Model;


class SprintTaskHistory extends Model implements SprintTaskHistoryInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'sprint__tasks_history';

    public $timestamps = false;
    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "sprint__tasks_id",
        "sprint_id",
        "status_id",
        "active",
        "resolve_time",
        "date",
        "created_at"
    ];

}
