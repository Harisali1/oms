<?php

namespace App\Models;


use App\Models\Interfaces\MerchantIdInterface;
use App\Models\Interfaces\SprintConfirmationInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MerchantIds extends Model implements MerchantIdInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'merchantids';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


    public function Task()
    {
        return $this->belongsTo(SprintTask::class,'task_id','id');
    }


}