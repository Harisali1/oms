<?php

namespace App\Models;

use App\Http\Traits\BasicModelFunctions;
use App\Models\Interfaces\TaskInterface;
use Illuminate\Database\Eloquent\Model;


class SprintTask extends Model implements TaskInterface
{
    /**
     * Table name.
     *
     * @var array
     */
    use BasicModelFunctions;

    public $table = 'sprint__tasks';

    protected $guarded = [];


    public function Sprint()
    {
        return $this->belongsTo(Sprint::class,'sprint_id','id');
    }
    public function getDynamicStatus($status_id)
    {
        $dynamic_tracking_status = [];
        $status_array = array_merge($this->getStatusCodes('competed'),$this->getStatusCodes('return'));
        if (in_array($status_id,[61])){
            $dynamic_tracking_status[1]['title'] = 'Preparing Order';
            $dynamic_tracking_status[1]['active'] = 1;
            $dynamic_tracking_status[1]['complete'] = 0;
            $dynamic_tracking_status[2]['title'] = 'At Hub Processing';
            $dynamic_tracking_status[2]['active'] = 0;
            $dynamic_tracking_status[2]['complete'] = 0;
            $dynamic_tracking_status[3]['title'] = 'Joey On The Way';
            $dynamic_tracking_status[3]['active'] = 0;
            $dynamic_tracking_status[3]['complete'] = 0;
            $dynamic_tracking_status[4]['title'] = 'Complete Order';
            $dynamic_tracking_status[4]['active'] = 0;
            $dynamic_tracking_status[4]['complete'] = 0;

        }
        elseif (in_array($status_id,[13,133,124,125])){
            $dynamic_tracking_status[1]['title'] = 'Preparing Order';
            $dynamic_tracking_status[1]['active'] = 0;
            $dynamic_tracking_status[1]['complete'] = 1;
            $dynamic_tracking_status[2]['title'] = 'At Hub Processing';
            $dynamic_tracking_status[2]['active'] = 1;
            $dynamic_tracking_status[2]['complete'] = 0;
            $dynamic_tracking_status[3]['title'] = 'Joey On The Way';
            $dynamic_tracking_status[3]['active'] = 0;
            $dynamic_tracking_status[3]['complete'] = 0;
            $dynamic_tracking_status[4]['title'] = 'Complete Order';
            $dynamic_tracking_status[4]['active'] = 0;
            $dynamic_tracking_status[4]['complete'] = 0;
        }
        elseif (in_array($status_id,[121])){
            $dynamic_tracking_status[1]['title'] = 'Preparing Order';
            $dynamic_tracking_status[1]['active'] = 0;
            $dynamic_tracking_status[1]['complete'] = 1;
            $dynamic_tracking_status[2]['title'] = 'At Hub Processing';
            $dynamic_tracking_status[2]['active'] = 0;
            $dynamic_tracking_status[2]['complete'] = 1;
            $dynamic_tracking_status[3]['title'] = 'Joey On The Way';
            $dynamic_tracking_status[3]['active'] = 1;
            $dynamic_tracking_status[3]['complete'] = 0;
            $dynamic_tracking_status[4]['title'] = 'Complete Order';
            $dynamic_tracking_status[4]['active'] = 0;
            $dynamic_tracking_status[4]['complete'] = 0;
        }
        elseif (in_array($status_id,$status_array)){
            $dynamic_tracking_status[1]['title'] = 'Preparing Order';
            $dynamic_tracking_status[1]['active'] = 0;
            $dynamic_tracking_status[1]['complete'] = 1;
            $dynamic_tracking_status[2]['title'] = 'At Hub Processing';
            $dynamic_tracking_status[2]['active'] = 0;
            $dynamic_tracking_status[2]['complete'] = 1;
            $dynamic_tracking_status[3]['title'] = 'Joey On The Way';
            $dynamic_tracking_status[3]['active'] = 0;
            $dynamic_tracking_status[3]['complete'] = 1;
            $dynamic_tracking_status[4]['title'] = 'Complete Order';
            $dynamic_tracking_status[4]['active'] = 1;
            $dynamic_tracking_status[4]['complete'] = 0;
        }
        else{

        }
        return $dynamic_tracking_status;
    }

    /**
     * Get Sprint Contacts
     */
    public function SprintContacts()
    {
        return $this->belongsTo( SprintContacts::class,'contact_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function contact()
    {
        return $this->belongsTo(SprintContacts::class);
    }

    public function merchant()
    {
        return $this->hasMany(MerchantIds::class, 'task_id', 'id');
    }

    public function time(){
        return $this->belongsTo(MerchantIds::class , 'id' , 'task_id');

    }

    public  function merchantIds(){
        return $this->belongsTo(MerchantIds::class,'id','task_id');
    }

    public  function sprintsSprintsForRoute(){
        return $this->belongsTo(Sprint::class,'sprint_id','id')
            ->whereNotIn('sprint__sprints.status_id',[17, 36, 101, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 116, 117, 118, 131, 132, 135, 136, 138, 139, 141, 143, 144, 145, 146]);
    }



}
