<?php

namespace App\Models;

use App\Models\Interfaces\ContactUsInterface;

use Illuminate\Database\Eloquent\Model;


class ContactUs extends Model implements ContactUsInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'contact_us';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}