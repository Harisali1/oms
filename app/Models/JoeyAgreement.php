<?php

namespace App\Models;

use App\Models\Interfaces\JoeyAgreementInterface;
use Illuminate\Database\Eloquent\Model;


class JoeyAgreement extends Model implements JoeyAgreementInterface
{

    public $table = 'agreements_user';

    protected $guarded = [];



}