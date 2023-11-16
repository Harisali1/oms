<?php

namespace App\Models;

use App\Models\Interfaces\AgreementInterface;
use Illuminate\Database\Eloquent\Model;


class Agreement extends Model implements AgreementInterface
{

    public $table = 'agreements';

    protected $guarded = [];



}