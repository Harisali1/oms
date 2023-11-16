<?php

namespace App\Models;

use App\Models\Interfaces\CardsInterface;
use Illuminate\Database\Eloquent\Model;


class Card extends Model implements CardsInterface
{

    public $table = 'cards';

    protected $guarded = [];



}