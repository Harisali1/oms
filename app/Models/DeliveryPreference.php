<?php

namespace App\Models;

use App\Models\Interfaces\DeliveryPreferenceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryPreference extends Model implements DeliveryPreferenceInterface
{
    use SoftDeletes;
    protected $fillable = [
        'title','status', 'deleted_at'
    ];

    public function orderCategory()
    {
        return $this->belongsToMany(OrderCategory::class);
    }
}
