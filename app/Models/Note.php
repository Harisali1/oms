<?php

namespace App\Models;

use App\Models\Interfaces\NoteInterface;
use Illuminate\Database\Eloquent\Model;


class Note extends Model implements NoteInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'notes';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}
