<?php

namespace App\Models;

use App\Models\Interfaces\JoeyDepositInterface;
use Illuminate\Database\Eloquent\Model;


class JoeyDeposit extends Model implements JoeyDepositInterface
{

    public $table = 'joey_deposit';

    protected $guarded = [];



}