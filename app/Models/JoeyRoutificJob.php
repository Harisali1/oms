<?php

namespace App\Models;

use App\Models\Interfaces\JoeyRoutificJobInterface;
use Illuminate\Database\Eloquent\Model;

class JoeyRoutificJob extends Model implements JoeyRoutificJobInterface
{
    protected $table = 'joey_routific_jobs';

    protected $fillable = ['job_id'];

}
