<?php
/**
 * Created by PhpStorm.
 * User: Joeyco-0031PK
 * Date: 10/6/2021
 * Time: 3:37 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonesType extends Model
{
    protected $fillable = [
        'title',
        'amount',
    ];
}