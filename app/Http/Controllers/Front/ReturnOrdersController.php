<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\StoreSubAdminRequest;
use App\Http\Requests\Front\UpdateSubAdminRequest;
use App\Models\FinancialTransactions;
use App\Models\Joey;
use App\Models\JoeysZoneSchedule;
use App\Models\JoeyTransactions;
use App\Models\Location;
use App\Models\MerchantIds;
use App\Models\ReturnOrder;
use App\Models\Roles;
use App\Models\Sprint;
use App\Models\SprintTask;
use App\Models\SprintTaskHistory;
use App\Models\User;
use App\Models\VendorTransaction;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class ReturnOrdersController extends Controller
{
    private $userRepository;

    public function index(Request $request)
    {
        if(empty($request->all())){
            $input = $request->all();
            $start = date('Y-m-d');
            $end = date('Y-m-d');
        }else{
            $input = $request->all();
                $start = $input['start'] ;
                $end = $input['end'];
        }

        $start_dt = new DateTime($start." 00:00:00", new DateTimezone('America/Toronto'));
        $start_dt->setTimeZone(new DateTimezone('UTC'));
        $start = $start_dt->format('Y-m-d H:i:s');

        $end_dt = new DateTime($end." 23:59:59", new DateTimezone('America/Toronto'));
        $end_dt->setTimeZone(new DateTimezone('UTC'));
        $end = $end_dt->format('Y-m-d H:i:s');


        $ReturnData = Sprint::join('joeys','joeys.id','=','sprint__sprints.joey_id')
            ->whereNull('sprint__sprints.deleted_at')
            ->whereNull('joeys.deleted_at')
            ->whereBetween('sprint__sprints.created_at',[$start,$end])
            ->whereIn('status_id',[101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143,18])
            ->select('sprint__sprints.id','sprint__sprints.creator_id','sprint__sprints.created_at','joeys.first_name','joeys.last_name','sprint__sprints.joey_id', DB::raw('count(*) as count'))
            ->groupBy('sprint__sprints.joey_id')
            ->get();

        return view('front.returnorder.index',compact('ReturnData'));
    }


    public function Details(Request $request)
    {
        $input = $request->all();

        $start = $_GET['start']? $_GET['start']: date('Y-m-d');
        $end = $_GET['end']? $_GET['end']: date('Y-m-d');


        $start_dt = new DateTime($start." 00:00:00", new DateTimezone('America/Toronto'));
        $start_dt->setTimeZone(new DateTimezone('UTC'));
        $start = $start_dt->format('Y-m-d H:i:s');

        $end_dt = new DateTime($end." 23:59:59", new DateTimezone('America/Toronto'));
        $end_dt->setTimeZone(new DateTimezone('UTC'));
        $end = $end_dt->format('Y-m-d H:i:s');

        $DetailData = Sprint::join('vendors','vendors.id','=','sprint__sprints.creator_id')
            ->whereNull('sprint__sprints.deleted_at')
            ->join('sprint__tasks','sprint__tasks.sprint_id','=','sprint__sprints.id')
            ->where('sprint__tasks.type','dropoff')
            ->whereNull('vendors.deleted_at')
            ->where('sprint__sprints.joey_id',$_GET['id'])
            ->whereBetween('sprint__sprints.created_at',[$start,$end])
            ->whereIn('sprint__sprints.status_id',[101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143,145,18])
            ->select('sprint__sprints.status_id','sprint__sprints.id','sprint__tasks.id as task_id','sprint__sprints.creator_id','vendors.name','vendors.location_id as pickup_location_id','sprint__tasks.location_id as dropoff_location_id','sprint__tasks.type','sprint__tasks.created_at')
            ->orderBy('sprint__sprints.created_at','asc')
            ->get();

        return view('front.returnorder.detail',compact('DetailData'));
    }

    public function ApproveOrder(Request $request){
        $input = $request->all();

        $get_return_data = ReturnOrder::whereNull('deleted_at')->where('id',$input['id'])->first();

        $return_order_id = $get_return_data->id;
        $return_sprint_id = $get_return_data->sprint_id;
        $return_task_id = $get_return_data->task_id;
        $return_joey_id = $get_return_data->joey_id;

        $task=SprintTask::where('sprint_id',$return_sprint_id)->first();
        $sprint_rec=Sprint::where('id',$task->sprint_id)->first();
        $joey = Joey::where('id',4743)->first();

        // get task pay
        $getTaskPay=$this->getTaskPay($joey,$task);

        $joey_pay=$getTaskPay['joey_pay'];
        $joeyco_pay=$getTaskPay['joeyco_pay'];
        $task->update(['active'=>1,'status_id'=>145,'joey_pay'=>$joey_pay,'joeyco_pay'=>$joeyco_pay]);
        // get task pay end

        // get sprint pay
        $total_joey_pay=0;
        $total_joeyco_pay=0;
        $all_tasks= $sprint_rec->SprintTasks;
        $getSprintPay=$this->getSprintPay($all_tasks,$task);
        $total_joey_pay=$getSprintPay['total_joey_pay'];
        $total_joeyco_pay=$getSprintPay['total_joeyco_pay'];
        $joey_tax_pay = $getSprintPay['joey_tax_pay'];
        // get sprint pay end



        Sprint::where('id',$task->sprint_id)->update(['status_id'=>145,'joey_pay'=>$total_joey_pay+$task->sprintsSprints->tip,'joeyco_pay'=>$total_joeyco_pay,'joey_tax_pay'=>$joey_tax_pay]);

        // --------------------------------------------------------------------------
        $this->recordJoeyPayment($task,$total_joey_pay,$joey_tax_pay);
        $totalVendorPay=$total_joey_pay+$total_joeyco_pay;
        $percentTotalVendorPay=($totalVendorPay*13)/100;
        $returnTotalVendorPay = $percentTotalVendorPay+$totalVendorPay;
        $this->recordVendorPayment($task,$returnTotalVendorPay);
        //---------------------------------------------------------------------------

        $update = DB::table('return_order')
            ->where('id',$input['id'])
            ->update(['is_approve' => 1]);

        if($update){
echo 1;
        }else{
echo 0;
        }

    }

    public function getTaskPay($joey=[],$task=[])
    {
        $joey_pay=0;
        $joeyco_pay=$task->charge;
        $joeyZone_shift_check=[];
        $from = date('Y-m-d').' 00:00:00';
        $to = date('Y-m-d').' 23:59:59';

        $joeyZone_shift_check=JoeysZoneSchedule::where('start_time','<=',$to)
            ->whereNull('end_time')
            ->whereBetween('start_time', [$from, $to])
            ->where('joey_id',$joey->id)->first();

        if($joeyZone_shift_check!=null){ //on shift

            if(($joeyZone_shift_check->ZoneSchedule)!=null){
                if ($joeyZone_shift_check->ZoneSchedule->commission!=null) {
                    $joey_pay=number_format((float)($joeyZone_shift_check->ZoneSchedule->commission/100), 2, '.', '')*$task->charge;
                    $joeyco_pay=number_format((float)(($task->charge)-$joey_pay),1, '.', '');

                }else{
                    if($joey->getPlan!=null) {
                        if($joey->getPlan->scheduled_commission!=null){
                            $joey_pay=number_format((float)($joey->getPlan->scheduled_commission/100), 2, '.', '')*$task->charge;
                            $joeyco_pay=number_format((float)(($task->charge)-$joey_pay),1, '.', '');
                        }
                    }
                }
            }
        }
        else{ //off shift
            if($joey->getPlan!=null) {
                if($joey->getPlan->unscheduled_commission!=null){
                    $joey_pay=number_format((float)($joey->getPlan->unscheduled_commission/100), 2, '.', '')*$task->charge;
                    $joeyco_pay=number_format((float)(($task->charge)-$joey_pay),1, '.', '');

                }
            }
        }
        $return['joey_pay']= $joey_pay;
        $return['joeyco_pay']=$joeyco_pay;

        return $return;
    }

    public function getSprintPay($all_tasks=[], $currentTask)
    {
        $total_joey_pay=0;
        $total_joeyco_pay=0;
        $joey_tax_pay=0;
        if(count($all_tasks)>0){

            $lastTask = $all_tasks->toArray();
            $lastDropOff = end($lastTask);

            if($currentTask->ordinal == $lastDropOff['ordinal']){

                $joey_pay=0;
                $joeyco_pay=0;
                $joeyZone_shift_check=[];
                $from = date('Y-m-d').' 00:00:00';
                $to = date('Y-m-d').' 23:59:59';

                $joey = User::find(auth()->user()->id);

                $sprint = Sprint::find($lastDropOff['sprint_id']);

                $totalCharge = $sprint->task_total+$sprint->distance_charge;

                $taxcharges = 0;
                $joey_tax_pay=0;
                if(!empty($joey->hst_number) || $joey->hst_number != NUll || $joey->hst_number != ''){
                    $taxcharges = $sprint->tax;
                }

                $joeyZone_shift_check=JoeysZoneSchedule::where('start_time','<=',$to)
                    ->whereNull('end_time')
                    ->whereBetween('start_time', [$from, $to])
                    ->where('joey_id',$joey->id)->first();

                if($joeyZone_shift_check!=null){ //on shift
                    if(($joeyZone_shift_check->ZoneSchedule)!=null){
                        if ($joeyZone_shift_check->ZoneSchedule->commission!=null) {
                            $joey_pay=number_format((float)($joeyZone_shift_check->ZoneSchedule->commission/100), 2, '.', '')*$totalCharge;

                            if($taxcharges > 0){
                                $joey_tax_pay=number_format((float)($joeyZone_shift_check->ZoneSchedule->commission/100), 2, '.', '')*$taxcharges;
                            }

                            $joeyco_pay=number_format((float)(($totalCharge)-$joey_pay),1, '.', '');

                        }else{
                            if($joey->getPlan!=null) {
                                if($joey->getPlan->scheduled_commission!=null){
                                    $joey_pay=number_format((float)($joey->getPlan->scheduled_commission/100), 2, '.', '')*$totalCharge;

                                    if($taxcharges > 0){
                                        $joey_tax_pay=number_format((float)($joey->getPlan->scheduled_commission/100), 2, '.', '')*$taxcharges;
                                    }

                                    $joeyco_pay=number_format((float)(($totalCharge)-$joey_pay),1, '.', '');

                                }
                            }
                        }
                    }
                }
                else{ //off shift
                    if($joey->getPlan!=null) {
                        if($joey->getPlan->unscheduled_commission!=null){
                            $joey_pay=number_format((float)($joey->getPlan->unscheduled_commission/100), 2, '.', '')*$totalCharge;

                            if($taxcharges > 0){
                                $joey_tax_pay=number_format((float)($joey->getPlan->unscheduled_commission/100), 2, '.', '')*$taxcharges;
                            }

                            $joeyco_pay=number_format((float)(($totalCharge)-$joey_pay),1, '.', '');

                        }
                    }
                }
                $return['total_joey_pay']= $joey_pay;
                $return['joey_tax_pay']=$joey_tax_pay;
                $return['total_joeyco_pay']=$joeyco_pay;
                return $return;
            }

            foreach ($all_tasks as $singleTask) {
                $total_joey_pay+=$singleTask->joey_pay;
                $total_joeyco_pay+=$singleTask->joeyco_pay;
            }
        }
        $return['total_joey_pay']= $total_joey_pay;
        $return['joey_tax_pay']=$joey_tax_pay;
        $return['total_joeyco_pay']=$total_joeyco_pay;
        return $return;
    }

    function recordJoeyPayment($task=[],$total_joeyco_pay,$joey_tax_pay){
        $tip=0;
        $balance=0;
        $transaction=FinancialTransactions::create([
            'reference'=>'CR-'.$task->sprint_id,
            'description'=>'CR-'.$task->sprint_id.' Confirmed',
            'amount'=>$total_joeyco_pay,
            'merchant_order_num'=>($task->merchantIds!=null)?$task->merchantIds->merchant_order_num:null
        ]);


        $joey_id=$task->sprintsSprints->joey_id;
        $lastJoeyTransaction=JoeyTransactions::where('joey_id',$joey_id)->orderBy('transaction_id','desc')->first();


        $taskAcceptedJoey=SprintTaskHistory::where('status_id',32)->where('sprint__tasks_id',$task->id)->where('sprint_id',$task->sprint_id)->first();

        $secsDiff =0;
        $joeyzone=[];
        if($taskAcceptedJoey!=null){

            $secsDiff = time() - strtotime($taskAcceptedJoey->date);

            $joeyzone=JoeysZoneSchedule::where('joey_id',$joey_id)->where('start_time', '<=',$taskAcceptedJoey->date)->whereNull('end_time')->orderBy('id','DESC')->first();

        }
        $joeyTransactionsdata=[
            'transaction_id'=>$transaction->id,
            'joey_id'=>$joey_id,
            'type'=>'sprint',
            'payment_method'=>null,
            'distance'=>($task->sprintsSprints!=null)?$task->sprintsSprints->distance:null,
            'duration'=>($secsDiff)?$secsDiff:0,
            'date_identifier'=>null,
            'shift_id'=>($joeyzone!=null)?$joeyzone->zone_schedule_id:null,
            'balance'=>((isset($lastJoeyTransaction->balance))?$lastJoeyTransaction->balance:0)+$total_joeyco_pay
        ];
        JoeyTransactions::insert($joeyTransactionsdata);
        $balance=$joeyTransactionsdata['balance'];

        // Tax Transaction //

        if($joey_tax_pay > 0){

            $transactionTax=FinancialTransactions::create([
                'reference'=>'CR-'.$task->sprint_id.'-Tax',
                'description'=>'Tax for Order: CR-'.$task->sprint_id,
                'amount'=>($joey_tax_pay)?$joey_tax_pay:null,
                'merchant_order_num'=>($task->merchantIds!=null)?$task->merchantIds->merchant_order_num:null
            ]);

            $joeyTaxTransactionsdata=[
                'transaction_id'=>$transactionTax->id,
                'joey_id'=>$joey_id,
                'type'=>'tax',
                'payment_method'=>null,
                'distance' => null,
                'duration'=> null,
                'date_identifier'=>null,
                'shift_id'=>($joeyzone!=null)?$joeyzone->zone_schedule_id:null,
                'balance'=>$balance+$joey_tax_pay
            ];
            JoeyTransactions::insert($joeyTaxTransactionsdata);

            $balance=$joeyTaxTransactionsdata['balance'];

        }

        // Tax Transaction End


        //Tip------------------------------------------------------------------------------------------------------------------

        $allTasks=$task->sprintsSprints->SprintTasks;
        $lastTask=$allTasks[count($allTasks)-1];


        if($lastTask->id==$task->id){

            $tip=($task->sprintsSprints->tip==null)?0:$task->sprintsSprints->tip;

            if($tip > 0){
                $transactionTip=FinancialTransactions::create([
                    'reference'=>'CR-'.$task->sprint_id.'-tip',
                    'description'=>'Tip for Order: CR-'.$task->sprint_id,
                    'amount'=>($tip)?$tip:0,
                    'merchant_order_num'=>($task->merchantIds!=null)?$task->merchantIds->merchant_order_num:null
                ]);

                $joeyTipTransactionsdata=[
                    'transaction_id'=>$transactionTip->id,
                    'joey_id'=>$joey_id,
                    'type'=>'tip',
                    'payment_method'=>null,
                    'distance' => null,
                    'duration'=> null,
                    'date_identifier'=>null,
                    'shift_id'=>($joeyzone!=null)?$joeyzone->zone_schedule_id:null,
                    'balance'=>$balance+$tip
                ];
                JoeyTransactions::insert($joeyTipTransactionsdata);

                $balance=$joeyTipTransactionsdata['balance'];
            }


        }

        //Tip--------------------------------------------------------------------------------------------------------------------------

        Joey::where('id',$joey_id)->update(['balance'=> $balance]);




    }

    function recordVendorPayment($task=[],$total_vendor_pay){
        $transaction=FinancialTransactions::create([
            'reference'=>'CR-'.$task->sprint_id,
            'description'=>'CR-'.$task->sprint_id.' Confirmed',
            'amount'=>$total_vendor_pay,
            'merchant_order_num'=>($task->merchantIds!=null)?$task->merchantIds->merchant_order_num:null
        ]);

        $vendor_id=$task->sprintsSprints->creator_id;
        $lastvendorTransaction=VendorTransaction::where('vendor_id',$vendor_id)->orderBy('transaction_id','desc')->first();


        $scheduleTime=SprintTaskHistory::where('status_id',24)->where('sprint__tasks_id',$task->id)->where('sprint_id',$task->sprint_id)->orderBy('id','DESC')->first();
        $pickUpTime=SprintTaskHistory::whereIn('status_id',[28,15])->where('sprint_id',$task->sprint_id)->orderBy('id','DESC')->first();


        $secsDiff=0;
        if(isset($pickUpTime) && isset($scheduleTime)){
            if($scheduleTime!=null && $pickUpTime != null){
                $secsDiff = strtotime($pickUpTime->date) - strtotime($scheduleTime->date);
            }
        }


        $vendorTransactionsdata=[
            'transaction_id'=>$transaction->id,
            'vendor_id'=>$vendor_id,
            'type'=>'sprint',
            'payment_method'=>null,
            'distance'=>($task->sprintsSprints!=null)?$task->sprintsSprints->distance:null,
            'duration'=>$secsDiff,
            'date_identifier'=>null,
            'balance'=>((isset($lastvendorTransaction->balance))?$lastvendorTransaction->balance:0)+$total_vendor_pay
        ];
        VendorTransaction::insert($vendorTransactionsdata);

        // tip transaction of vendor

        $allTasks=$task->sprintsSprints->SprintTasks;
        $lastTask=$allTasks[count($allTasks)-1];

        $lastvendorTransactionData=VendorTransaction::where('vendor_id',$vendor_id)->orderBy('transaction_id','desc')->first();

        if($lastTask->id==$task->id){
            $tip=($task->sprintsSprints->tip==null)?0:$task->sprintsSprints->tip;

            if($tip > 0){
                $transactionTip=FinancialTransactions::create([
                    'reference'=>'CR-'.$task->sprint_id.'-tip',
                    'description'=>'Tip for Order: CR-'.$task->sprint_id,
                    'amount'=>$tip,
                    'merchant_order_num'=>($task->merchantIds!=null)?$task->merchantIds->merchant_order_num:null
                ]);

                $vendorTransactionsdata=[
                    'transaction_id'=>$transactionTip->id,
                    'vendor_id'=>$vendor_id,
                    'type'=>'tip',
                    'payment_method'=>null,
                    'distance'=>null,
                    'duration'=>null,
                    'date_identifier'=>null,
                    'balance'=>((isset($lastvendorTransactionData->balance))?$lastvendorTransactionData->balance:0)+$task->sprintsSprints->tip
                ];
                VendorTransaction::insert($vendorTransactionsdata);

            }
        }

    }

}
