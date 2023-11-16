<?php

namespace App\Models;

//use App\Models\Interfaces\CitiesInterface;
use Illuminate\Database\Eloquent\Model;

class SprintContacts extends Model //implements CitiesInterface
{

    /**
     * Table name.
     *
     * @var array
     */
    public $table = 'sprint__contacts';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [

    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * ORM Relation
     *
     * @var array
     */




}
