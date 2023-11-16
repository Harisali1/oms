<?php

namespace App\Http\Controllers\Front;

use App\Models\cancelOrder;
use App\Models\Dispatch;
use App\Models\ExclusiveOrderJoey;
use App\Models\Interfaces\DispatchInterface;
use App\Models\Joey;
use App\Models\OmsCategory;
use App\Models\JoeyLocation;
use App\Models\JoeyRouteLocation;
use App\Models\JoeyRoutes;
use App\Models\Location;
use App\Models\Note;
use App\Models\Sprint;
use App\Models\SprintContacts;
use App\Models\SprintTask;
use App\Models\SprintTaskHistory;
use App\Models\SprintZone;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Models\Zones;
use App\Models\ZoneVendorRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class DispatchController extends Controller
{

    private $test = array(
        "136" => "Client requested to cancel the order",
        "137" => "Delay in delivery due to weather or natural disaster",
        "118" => "left at back door",
        "117" => "left with concierge",
        "135" => "Customer refused delivery",
        "108" => "Customer unavailable-Incorrect address",
        "106" => "Customer unavailable - delivery returned",
        "107" => "Customer unavailable - Left voice mail - order returned",
        "109" => "Customer unavailable - Incorrect phone number",
        "142" => "Damaged at hub (before going OFD)",
        "143" => "Damaged on road - undeliverable",
        "144" => "Delivery to mailroom",
        "103" => "Delay at pickup",
        "139" => "Delivery left on front porch",
        "138" => "Delivery left in the garage",
        "114" => "Successful delivery at door",
        "113" => "Successfully hand delivered",
        "120" => "Delivery at Hub",
        "110" => "Delivery to hub for re-delivery",
        "111" => "Delivery to hub for return to merchant",
        "121" => "Pickup from Hub",
        "102" => "Joey Incident",
        "104" => "Damaged on road - delivery will be attempted",
        "105" => "Item damaged - returned to merchant",
        "129" => "Joey at hub",
        "128" => "Package on the way to hub",
        "140" => "Delivery missorted, may cause delay",
        "116" => "Successful delivery to neighbour",
        "132" => "Office closed - safe dropped",
        "101" => "Joey on the way to pickup",
        "32" => "Order accepted by Joey",
        "14" => "Merchant accepted",
        "36" => "Cancelled by JoeyCo",
        "124" => "At hub - processing",
        "38" => "Draft",
        "18" => "Delivery failed",
        "56" => "Partially delivered",
        "17" => "Delivery success",
        "68" => "Joey is at dropoff location",
        "67" => "Joey is at pickup location",
        "13" => "Waiting for merchant to accept",
        "16" => "Joey failed to pickup order",
        "57" => "Not all orders were picked up",
        "15" => "Order is with Joey",
        "112" => "To be re-attempted",
        "131" => "Office closed - returned to hub",
        "125" => "Pickup at store - confirmed",
        "61" => "Scheduled order",
        "37" => "Customer cancelled the order",
        "34" => "Customer is editting the order",
        "35" => "Merchant cancelled the order",
        "42" => "Merchant completed the order",
        "54" => "Merchant declined the order",
        "33" => "Merchant is editting the order",
        "29" => "Merchant is unavailable",
        "24" => "Looking for a Joey",
        "23" => "Waiting for merchant(s) to accept",
        "28" => "Order is with Joey",
        "133" => "Packages sorted",
        "55" => "ONLINE PAYMENT EXPIRED",
        "12" => "ONLINE PAYMENT FAILED",
        "53" => "Waiting for customer to pay",
        "141" => "Lost package",
        "60" => "Task failure",
        "255" =>"Order delay",
        "145"=>"Returned To Merchant",
        "146" => "Delivery Missorted, Incorrect Address",
        "147" => "Scanned at hub",
        "148" => "Scanned at Hub and labelled",
        "149" => "",
        "150" => "",
        "151" => "",
        "152" => "",
    );

    //Create a new controller instance.
    public function __construct()
    {
    }

    // Grocery Dispatch View
    public function groceryIndex(Request $request)
    {

        $omsCategory = OmsCategory::where('is_active', 1)->get();
        $zones = Zones::whereNull('deleted_at')->get();
        $vendors = Vendor::whereNull('deleted_at')->get();

        $stuckquery =  Dispatch::where('status',115)
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $stuck = count($stuckquery);

        // $new = Dispatch::where('status',13)
        //     ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
        //     ->pluck('sprint_id');
        // $newOrders = count($new);

        $activequery = Dispatch::whereIn('status', [32,24,15,28,67,68])
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $active = count($activequery);

        $completedquery = Dispatch::where('dispatch.date', '>=', Carbon::now()
            ->subDays(2)
            ->timestamp)
            ->whereIn('status', [17,113,114,116,117,118,132,138,139,144])
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $completed = count($completedquery);

        $rejectedquery = Dispatch::where('dispatch.date', '>=', Carbon::now()
            ->subDays(2)
            ->timestamp)
            ->whereIn('status', [35,36,37])
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $rejected = count($rejectedquery);

        $returnedquery = Dispatch::whereIn('status', [101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143])
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $returned = count($returnedquery);

        $scheduledquery = Dispatch::where('status',61)
            ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->pluck('sprint_id');
        $scheduled = count($scheduledquery);

        //$scheduled = 0;
        //$returned=0;
        //$rejected=0;
        //$completed=0;
        //$active=0;
        $new=0;
        //$stuck=0;

        return view('front.dispatch.dispatch-orders', compact('omsCategory','stuck', 'new','active','completed','rejected','returned','scheduled', 'zones', 'vendors'));
    }

    // Grocery Dispatch fetch ajax data
    public function groceryData(DataTables $datatables, Request $request): JsonResponse
    {
        // Dispatch Query
        $query = Dispatch::join('sprint__sprints', 'dispatch.sprint_id', '=', 'sprint__sprints.id')
//            ->join('sprint__tasks', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
//            ->join('sprint__contacts', 'sprint__tasks.contact_id', '=', 'sprint__contacts.id')
            ->join('shopping_users', 'sprint__sprints.creator_id', '=', 'shopping_users.id');
//            ->leftJoin('joeys', 'dispatch.joey_id', '=', 'joeys.id');
        if($request->categoryId != null){
            $query = $query->where('oms_order_id', $request->categoryId);
        }

        // Search By OrderId And Phone Number
        if ($request->orderId != null || $request->phoneNo != null) {
            $query = $this->searchByOrderIdAndPhoneNo($request, $query);
        }

        // Condition For OrderType Statuses
        if ($request->orderType != null) {
            $query = $this->filteredByOrderType($request, $query);
        }

        // Condition By Zone And Vendor Filter Form
        if ($request->orderStatus != null || $request->orderZones != null || $request->orderVendors != null) {
            $query = $this->filteredByStatusZoneAndVendor($request, $query);
        }

        // By Default Fetch Active Record Of Dispatch
        if ($request->orderType == null && $request->orderStatus == null && $request->orderZones == null && $request->orderVendors == null) {
            $query->whereIn('dispatch.status', [32, 24, 15, 28, 67, 68]);
        }

        // Select Column Query
        $query->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360'])
            ->select('dispatch.*');

//        dd($query->toSql());
        // Return and execute Datatable
        return $this->dataTable($datatables, $query);
    }

    // Search By OrderId And Phone Number
    protected function searchByOrderIdAndPhoneNo($request, $query)
    {
        $orderId = $request->orderId;
        $phoneNo = $request->phoneNo;
        // If you entered OrderId
        if ($orderId != null) {
            $query->where('num', $orderId);
        }

        // if you entered phone number
        if ($phoneNo != null) {
            $query->where('dropoff_contact_phone', '+' . $phoneNo);
        }
        return $query;
    }

    // Filtered By OrderType
    protected function filteredByOrderType($request, $query)
    {
        // Rejected And Completed Status Condition for two days only
        $rejectedStatus = [36, 37, 35];
        $completedStatus = [17, 113, 114, 116, 117, 118, 132, 138, 139, 144];

        if (in_array($request->orderType, $completedStatus)) {
            $query->where('dispatch.date', '>=', Carbon::now()->subDays(2)->timestamp)->whereIn('dispatch.status', [17, 113, 114, 116, 117, 118, 132, 138, 139, 144]);
        }

        if (in_array($request->orderType, $rejectedStatus)) {
            $query->where('dispatch.date', '>=', Carbon::now()->subDays(2)->timestamp)->whereIn('dispatch.status', [35, 36, 37]);
        }

        if ($request->orderType == 115) {
            $query->whereIn('dispatch.status', [115]);
        }

        if ($request->orderType == 13) {
            $query->whereIn('dispatch.status', [13]);
        }

        if ($request->orderType == 61) {
            $query->whereIn('dispatch.status', [61]);
        }

        if($request->orderType == 101){
            $query->whereIn('dispatch.status', [101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143]);
        }

        if($request->orderType == 32){
            $query->whereIn('dispatch.status', [32, 24, 15, 28, 67, 68]);
        }

        return $query;
    }

    // filtered by zone, vendor, and status
    protected function filteredByStatusZoneAndVendor($request, $query)
    {

        $orderStatus = $request->orderStatus;
        $orderZones = $request->orderZones;
        $orderVendors = $request->orderVendors;

        if ($orderZones != null) {
            $orderZones = explode(',', $orderZones);
            $query->join('sprint__sprint_zone', 'sprint__sprint_zone.sprint_id', '=', 'sprint__sprints.id')
                ->whereIn('dispatch.status', [32, 24, 15, 28, 67, 68])
                ->whereIn('sprint__sprint_zone.zone_id', $orderZones);
        }

        if ($orderVendors != null) {
            $orderVendors = explode(',', $orderVendors);
            $query->whereIn('dispatch.status', [32, 24, 15, 28, 67, 68])
                ->whereIn('sprint__sprints.creator_id', $orderVendors);
        }

        if ($orderStatus != null) {
            $query->where('dispatch.status', $orderStatus);
        }
        return $query;
    }

    // datatable
    protected function dataTable($datatables, $query)
    {
        return $datatables->eloquent($query)
            ->setRowId(static function ($record) {
                return $record->num;
            })
            ->editColumn('date', static function ($record) {
                return ConvertTimeZone($record->date, 'America/Toronto', 'UTC');
                //return $record->vendor_name;
            })
            ->editColumn('dropoff_etc', static function ($record) {
                return ConvertTimeZone($record->date, 'America/Toronto', 'UTC');
                //return $record->vendor_name;
            })
            ->editColumn('distance', static function ($record) {
                return $record->distance . ' km';
            })
            ->editColumn('vendor_name', static function ($record) {
                $vendor = '<ul class="no-list attr-list">
                            <li><i class="icofont-user"></i>
                                ' . $record->pickup_contact_name . '
                            </li>
                            <li><i class="icofont-phone"></i>
                                ' . $record->pickup_contact_phone . '
                            </li>
                        </ul>';
                return $vendor;
            })
            ->editColumn('customer_name', static function ($record) {
                $btn = '<ul class="no-list attr-list">
                            <li><i class="icofont-phone"></i>
                                ' . $record->dropoff_contact_phone . '
                            </li>
                            <li><i class="icofont-google-map"></i>
                                ' . $record->dropoff_address . '
                            </li>
                        </ul>';
                return $btn;
            })
            ->editColumn('status', static function ($record) {
                return getStatusCodesWithKey('status_labels.' . $record->status);
            })
            ->addColumn('action', static function ($record) {
                $dispatch = $record->id;
                $sprint = $record->sprint_id;
                $status = $record->status;
                return view('front.dispatch.action', compact('dispatch', 'sprint', 'status'));
            })
            ->rawColumns(['vendor_name', 'customer_name', 'customer_email', 'customer_phone'])
            ->make(true);
    }

    //open modals of transfer, assign and preBroadcast
    public function assignTransferAndPreBroadcastModalData(Dispatch $dispatch)
    {
        $joeys = Joey::where('on_duty', 1)->get();
        return json_encode(['joeys' => $joeys, 'dispatch' => $dispatch]);
    }

    // transfer order from joey to joey
    public function transferOrder(Joey $joey, Dispatch $dispatch)
    {

        $sprint = Sprint::find($dispatch->sprint_id);
        $sprint->update(
            [
                'joey_id' => $joey->id
            ]
            );

        $dispatch->update([
            'joey_id' => $joey->id,
            'joey_name' => $joey->first_name . ' ' . $joey->last_name
        ]);
        return json_encode(['message' => 'success']);
    }

    // assign order to joey
    public function assignOrder(Joey $joey, Dispatch $dispatch)
    {

        $deliveredStatus = [];
        $returnStatus = [];
        $pickupLat = 0.0;
        $pickupLng = 0.0;
        $dropOffLat = 0.0;
        $dropOffLng = 0.0;


        // get sprint and task
        $sprint = Sprint::find($dispatch->sprint_id);
        $tasks = SprintTask::where('sprint_id', $dispatch->sprint_id)->get();

        //get available routes
        $joeyRoute = JoeyRoutes::where('joey_id', $joey->id)->where('route_completed', 0)->first();

//        $joeyLocation = JoeyLocation::where('joey_id', $joey->id)->orderBy('id', 'DESC')->first();
//        if($joeyLocation == null){
//            return json_encode(['message' => 'Please Update your location first']);
//        }

//        $joeyLat = $joeyLocation->latitude/1000000;
//        $joeyLng = $joeyLocation->longitude/1000000;

//        foreach ($tasks as $task) {
//            if($task->type == 'pickup'){
//                $pickupLocation = Location::find($task->location_id);
//                $pickupLat = $pickupLocation->latitude/1000000;
//                $pickupLng = $pickupLocation->longitude/1000000;
//            }
//            if($task->type == 'dropoff'){
//                $dropOffLocation = Location::find($task->location_id);
//                $dropOffLat = $dropOffLocation->latitude/10000000;
//                $dropOffLng = $dropOffLocation->longitude/10000000;
//            }
//        }

//        $distance = $this->getDistanceBetweenPoints($joeyLat, $joeyLng, $pickupLat,$pickupLng,$dropOffLat,$dropOffLng);
//        if($distance == 0){
//            return json_encode(['message' => 'Route exceeds maximum distance limitation please check location']);
//        }

//        dd($distance);

        $key=1;
        if($joeyRoute == null){
            $route = JoeyRoutes::create([
                'joey_id' => $joey->id,
                'date' => date('Y-m-d H:i:s'),
                'total_travel_time' => '',
                'total_distance' => 123,
                'mile_type' => 6
            ]);
        }

        foreach ($tasks as $task) {
            JoeyRouteLocation::create([
                'route_id' => (isset($joeyRoute)) ? $joeyRoute->id : $route->id,
                'ordinal' => $key++,
                'task_id' => $task->id,
                'distance' => 123,
            ]);
        }

//        $routeIdForDispatchRoute = (isset($joeyRoute)) ? $joeyRoute->id : $route->id;
//
//        $routes = $this->joeyRouteLocationDataQuery($joey);
//
//        $sequenceRoute = $this->sequenceRoute($routes, $joeyLat, $joeyLng, $joey, $routeIdForDispatchRoute);
//
//        $saveDispatchRoute = $this->saveDispatchRoute($sequenceRoute);
//
//        dd($sequenceRoute);



        $sprint->update([
            'joey_id' => $joey->id,
            'status_id'=>32
        ]);

        $dispatch->update([
            'joey_id' => $joey->id,
            'joey_name' => $joey->first_name . ' ' . $joey->last_name,
            'status' => 32,
        ]);

        foreach ($tasks as $task) {
            SprintTask::find($task->id)->update(['status_id' => 32]);
            SprintTaskHistory::create([
                'sprint__tasks_id' => $task->id,
                'sprint_id' => $dispatch->sprint_id,
                'status_id' => 32,
                'active' => 0,
                'date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

        }


        return json_encode(['message' => 'successfully assign this order to joey']);
    }

    //rebroadcast order
    public function reBroadcastOrder(Request $request, Sprint $sprint)
    {
        $tasks = SprintTask::where('sprint_id', $sprint->id)->where('type', 'pickup')->get();
        $dispatch = Dispatch::find($request->get('dispatch_id'));
        $dispatch->update(['status' => 24]);
        $sprint->update(['status_id' => 24]);
        foreach ($tasks as $task) {
            $time = $task->due_time + ($request->get('hours') * 60 * 60) + ($request->get('minutes') * 60 * 60);
            $task->update([
                'due_time' => $time,
            ]);
            SprintTaskHistory::create([
                'sprint__tasks_id' => $task->id,
                'sprint_id' => $sprint->id,
                'status_id' => 24,
                'active' => 0,
            ]);
        }
    }

    //preBroadcast order to multiple joeys
    public function preBroadcastOrder(Request $request)
    {
        foreach ($request->get('joey_ids') as $joey_id) {
            $data = [
                'order_id' => $request->get('sprint_id'),
                'joey_id' => $joey_id,
            ];

            ExclusiveOrderJoey::create($data);
        }
        return json_encode(['message' => 'success']);
    }

    // Sprint Order Detail popup function
    public function sprintOrderDetail(Sprint $sprint)
    {
        $tasks = SprintTask::with('merchant', 'location', 'contact')->where('sprint_id', $sprint->id)->get();
        $dispatch = Dispatch::where('sprint_id', $sprint->id)->get();
        $status = getStatusCodesWithKey('status_labels.' . $dispatch[0]->status);

        return json_encode(['tasks' => $tasks, 'dispatch' => $dispatch, 'sprint' => $sprint, 'status' => $status]);
    }

    // sprint order cancel
    public function sprintCancel(Request $request, Sprint $sprint)
    {
        $sprint->update(['active' => 0]);
        $dispatch = Dispatch::find($request->get('dispatch_id'))->update(['status' => 36, 'status_copy' => 'Order cancelled']);
        $tasks = SprintTask::where('sprint_id', $sprint->id)->get();

        foreach ($tasks as $task) {
            $task->update([
                'active' => 0
            ]);
            SprintTaskHistory::create([
                'sprint__tasks_id' => $task->id,
                'sprint_id' => $sprint->id,
                'status_id' => 36,
                'active' => 0,
            ]);
        }

        CancelOrder::create([
            'sprint_id' => $sprint->id,
            'reason' => $request->get('reason')
        ]);

        return json_encode(['message' => 'success']);
    }

    //edit Order
    public function editOrder(Sprint $sprint)
    {
        $vehicles = Vehicle::all();
        $sprint = Sprint::with('joeys', 'SprintTasks', 'vehicles')->find($sprint->id);
        $dispatch = Dispatch::where('sprint_id', $sprint->id)->first();
        $status = getStatusCodesWithKey('status_labels.' . $dispatch->status);
        $paymentOptions = array('none', 'make', 'collect');

        return view('front.dispatch.edit-order', compact('sprint', 'status', 'vehicles', 'paymentOptions'));

    }

    //order map
    public function getMapLatLng(Sprint $sprint)
    {
        $locations = [];
        $tasks = SprintTask::where('sprint_id', $sprint->id)->get();
        foreach ($tasks as $key => $task) {
            $locationsLatLng = Location::find($task->location_id);
            $locations[] = [
                $locationsLatLng->address,
                substr($locationsLatLng->latitude, 0, 8) / 1000000,
                substr($locationsLatLng->longitude, 0, 9) / 1000000,
                $key + 1,
                $task->type,
            ];
        }
        return $locations;
    }

    //order Note
    public function OrderNote(Sprint $sprint, Request $request)
    {
        $notes = [
            'object_type' => 'com.joeyco.notes.sprint',
            'object_id' => $sprint->id,
            'creator_type' => 'com.joeyco.notes.users.admin',
            'creator_id' => auth()->user()->id,
            'target_type' => 'com.joeyco.notes.ops',
            'target_id' => '',
            'note' => $request->get('note'),
            'status' => '',
        ];

        $orderNotes = Note::create($notes);
        return json_encode(['message' => 'success', 'data' => $orderNotes]);
    }

    // Dispatch Order Views
    public function dispatchOrderNotes(Sprint $sprint)
    {
        $orderNotes = Note::where('object_id', $sprint->id)->get();
        return view('front.dispatch.order-notes', compact('orderNotes'));
    }

    // sprint Order Update
    public function sprintOrderUpdate(Request $request, Sprint $sprint)
    {
        $date = $request->get('due_time');
        $due_time = strtotime($date);

        $sprintData = [
            'vehicle_id' => $request->get('vehicle_id'),
            'tip' => $request->get('tip'),
        ];

        $dueTime = [
            'due_time' => $due_time,
        ];

        $sprint->update($sprintData);
        $sprint->SprintTasks()->update($dueTime);
        return redirect()->back();
    }

    //update Sprint Task
    public function sprintOrderTaskUpdate(Request $request, SprintTask $sprint_task)
    {
        $location = Location::find($sprint_task->location_id);
        $contact = SprintContacts::find($sprint_task->contact_id);

        $taskData = [
            'pin' => $request->get('pin'),
            'payment_type' => $request->get('payment_type'),
            'payment_amount' => $request->get('payment_amount'),
        ];

        $sprint_task->update($taskData);
        $location->update([
            'address' => $request->get('address'),
            'postal_code' => $request->get('postal_code')
        ]);
        $contact->update([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email')
        ]);
        return redirect()->back();
    }

    //Dispatch map view
    public function groceryDispatchMap()
    {
        $zones = Zones::whereNull('deleted_at')->get();
        $vendors = Vendor::whereIn('id',[475761,476610,476734,476850,476867,476933,476967,476968,476969,476970,477006,477068,477069,477078,477123,477124,477133,477150,477153,477154,477157,477192,477209,477233,
        477234,477235,477236,477237,477238,477239,477240,477241,477242,477244,477245,477246,477247,477248,477249,477250,477251,477252,477253,477267,477268,477271,477272,477273,477279,
        477285,477348,477349,477350,477351,477352,477353,477354,477355,477356,477357,477358,477359,477360,477361,477362,477363,477364,477365,477366,477367,477368,477369,477370,477371,
        477372,477373,477374,477375,477376,477377,477378,477379,477380,477381,477382,477383,477384,477385,477386,477387,477388,477389,477390,477391,477392,477393,477394,477395,477396,
        477397,477398,477399,477400,477401,477402,477403,477404,477405,477406,477407,477408,477409,477410,477411,477412,477413,477414,477415,477416,477417,477418,477419,477420,477421,
        477422,477423,477424,477425,477426,477438,477439,477451,477452,477454,477503,477281,477466,477467,477468,477469,477470,477194,477195,477205,477464,477465,477471,477472,477473,477474,477475,477164])->get();

        $joeys = Joey::whereNull('deleted_at')->where('on_duty',1)->get();

        return view('front.dispatch.dispatch-map-view', compact('zones', 'vendors', 'joeys'));
    }

    //search and filter by vendor and zones of orders markers
    public function dispatchMapView(Request $request)
    {


        $joey = $request->joey;
        $zones = $request->zones;
        $vendors = $request->vendors;
        $status = $request->statuses;
        $locations = [];

        $orders = Dispatch::where('status',$status)
        ->where('dispatch.date', '>=', Carbon::now()->subDays(5)->timestamp)
        ->whereNotIn('pickup_contact_name',['Toronto Hub','Amazon','Amazon Montreal','Amazon Ottawa','Sport Chek - SC288 (Milton)','Sport Check - SC243 (Etobicoke)','Sport Chek - SHERWAY GARDENS SC243',"Mark's Warehouse - M347",'Sport Chek SQUARE ONE SC355','Sport Chek Stockyards SC5141','Sport Chek Winston SC317','Sport Chek Fairview Mall SC251','Sport Chek Yorkdale SC375','Sport Chek Bramalea SC340','Sport Chek Eglinton Corners SC263','Sport Chek TDC DC3109','Marks Warehouse Heartland M86','Sport Chek Burlington SC352','Marks Warehouse Queensway M138','Sport Chek Leaside SC241','239 SC BRAMPTON TRINITY COMMONS','Marks Warehouse Oakville Dundas M168','Sport Chek Appleby SC257','Marks Warehouse Scarborough M74','Marks Warehouse Brampton North M69','Sport Chek Markham SC208','Marks Warehouse Hillcrest M534','Sport Chek Oakville SC5138','Marks Warehouse Burlington M64','Marks Warehouse Dixie Dundas M84','Marks Warehouse Steeles Kennedy M63','Atmosphere CMS DC7109','Marks Warehouse Lakeshore M540','Marks Warehouse Stockyards M82','Marks Warehouse Argentia M180','Marks Warehouse - M347','Marks Warehouse Woodbridge M87','Sport Chek Lakeshore SC540','Sport Chek Brampton SC974','Sport Chek Mississauga DC','Sport Chek Brampton DC','Sport Chek Brampton T-Commons SC239','Sport Chek Milton SC288','Sport Chek Milton SC288','Sport Chek Sherway Gardens SC243','Canadian Tire 169','Canadian Tire 143','Atmosphere Mississauga DC','Marks Warehouse - M68','SportChek SC395','SportChek SC5151','SportChek SC255','SportCheck SC5128','SportChek Richmond Hill SC255','SportChek SC5165','SportChek Toronto SC5151','SportChek SC5166','SportCheck Milton SC5128','SportChek SC266','SportChek SC350','SportChek SC330','SportChek SC264','SportChek SC398','SportChek Byward Market SC5165','SportChek Crestview SC350','SportChek Overbrook SC330','Xerox','SportChek Kanata SC266','SportChek Orleans SC398','SportChek Nepean SC264','SportChek Bayshore SC5166','Ottawa Hub','SportChek Richmond Hill SC395','SportChek Thornhill SC354','SportChek SC354','Marks Warehouse North York M68','CTC Test Merchant','test amazon ottawa','borderless360']);

        if(!empty($zones)){
            $orders->whereIn('zone_id', $zones);
        }
        if(!empty($joey)){
            $orders->where('joey_id',$joey);
        }
        if(!empty($vendors)){
            $orders->whereIn('pickup_contact_name',$vendors);
        }

        $orders = $orders->get();

        foreach($orders as $num => $order){

            // $pickuplocationsLatLng = Location::find($order->pickup_location_id);
            // if(!empty($pickuplocationsLatLng)){
            //     $locations[] = [
            //         $pickuplocationsLatLng->address,
            //         $pickuplocationsLatLng->latitude / 1000000,
            //         $pickuplocationsLatLng->longitude / 1000000,
            //         $num + 1,
            //         'pickup',
            //         $order->sprint_id,
            //     ];
            // }

            $droplocationsLatLng = Location::find($order->dropoff_location_id);
            if(!empty($droplocationsLatLng)){
                $locations[] = [
                    $droplocationsLatLng->address,
                    $droplocationsLatLng->latitude / 1000000,
                    $droplocationsLatLng->longitude / 1000000,
                    $num + 1,
                    'dropoff',
                    $order->sprint_id,
                    $this->test[$order->status],
                ];
            }
        }

        return $locations;
    }

//    public function getDistanceBetweenPoints($joeyLat, $joeyLng, $lat, $lng, $lat1, $lng1)
//    {
//        $token='pk.eyJ1Ijoiam9leWNvIiwiYSI6ImNpbG9vMGsydzA4aml1Y2tucjJqcDQ2MDcifQ.gyd_3OOVqdByGDKjBO7lyA';
//        try {
//            $response = file_get_contents('https://api.mapbox.com/directions/v5/mapbox/driving/'.$joeyLat.','.$joeyLng.';'.$lat.','.$lng.';'.$lat1.','.$lng1.'?access_token='.$token);
//            $response=json_decode($response,true);
//            if(isset($response['routes'][0]['distance'])){
//                return $response['routes'][0]['distance'];
//            }else{
//                $theta = $lng - $lng1;
//                $miles = (sin(deg2rad($lat)) * sin(deg2rad($lat1))) + (cos(deg2rad($lat)) * cos(deg2rad($lat1)) * cos(deg2rad($theta)));
//                $miles = acos($miles);
//                $miles = rad2deg($miles);
//                $miles = $miles * 60 * 1.1515;
//                $feet = $miles * 5280;
//                $yards = $feet / 3;
//                $kilometers = $miles * 1.609344;
//                $meters = $kilometers * 1000;
//                return $meters;
//            }
//        }catch (\Exception $exception){
//            return json_encode(['message' => $exception->getMessage()]);
//        }
//    }



}
