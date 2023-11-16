<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\RoleRequest;
use App\Http\Requests\Front\UpdateRoleRequest;
use App\Models\Permissions;
use App\Models\Roles;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleRepository;

    /**
     * Create a new controller instance.
     * @param RoleRepositoryInterface $roleRepositoryInterface
     */
    public function __construct(RoleRepositoryInterface $roleRepositoryInterface)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->roleRepository = $roleRepositoryInterface;
    }

    /**
     * Role View
     *
     */
    public function index()
    {
        $Roles =  Roles::NotAdminRole()->paginate(10);
        return view('front.roles.roles',compact('Roles'));

    }

    /**
     * Role Create View
     *
     */
    public function create()
    {
        // getting dashnboard card permissions
        $dashboard_card_permissions = Permissions::GetAllDashboardCardPermissions();

        return view('front.roles.add-role',compact('dashboard_card_permissions'));
    }

    /**
     * store action
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );

        // including dashboard cards rights

        $dashboard_cards_rights = '';

        if(isset($data['dashboard_card_permission']))
        {
            $dashboard_cards_rights = implode(",",$data['dashboard_card_permission']);
        }

        // creating inserting data

        $create = [
            'display_name' => $data['name'],
            'role_name' => SlugMaker($data['name']),
            'dashbaord_cards_rights' => $dashboard_cards_rights,
            'type'=> Roles::ROLE_TYPE_NAME,
        ];

        // inserting data
        $this->roleRepository->create($create);

        /*return data */
        return redirect()
            ->route('role.index')
            ->with('success', 'Role added successfully.');


    }

    /**
     * Set permission view
     *
     */
    public function setPermissions(Roles $role)
    {
        // getting permissions
        $permissions_list = Permissions::getAllPermissions();

        //dd($permissions_list);
        return view('front.roles.add-privileges',compact(
            'role',
            'permissions_list'
        ));
    }

    /**
     * Update permission
     *
     */
    public function setPermissionsUpdate(Request $request,$role)
    {
        // now creating insert data of permissions
        $insert_permissions = [];

        $role_permissions = $request->permissions ?? [];
        //$role_permissions = $request->permissions;

        foreach($role_permissions as $role_permission)
        {
            if(strpos($role_permission, '|') !== false)
            {
                foreach(explode('|',$role_permission) as $child_permission )
                {
                    $insert_permissions[] =['route_name'=> $child_permission, 'role_id'=>$role];
                }
            }
            else
            {
                $insert_permissions[] = ['route_name'=> $role_permission, 'role_id'=>$role];
            }

        }

        // deleting old data
        $delete = Permissions::where('role_id',$role)->update(['is_delete' => 1]);

        //inserting new data
        $crate_permissions = Permissions::insert($insert_permissions);

        /*return data */
        return redirect()
            ->route('role.index')
            ->with('success', 'Role permissions updated successfully.');

    }

    /**
     * edit action
     *
     */
    public function edit(Roles $role)
    {
        // getting dashnboard card permissions
        $dashboard_card_permissions = Permissions::GetAllDashboardCardPermissions();
        return view('front.roles.edit-role',compact(
            'role',
            'dashboard_card_permissions'
        ));
    }

    /**
     * update action
     *
     */
    public function update(UpdateRoleRequest $request,$role)
    {
        /*getting all requests data*/
        $Postdata = $request->all();

        /*including dashboard cards rights*/
        $dashboard_cards_rights = '';
        if(isset($Postdata['dashboard_card_permission']))
        {
            $dashboard_cards_rights = implode(",",$Postdata['dashboard_card_permission']);
        }

        /*creating updating data*/
        $update_data = [
            'display_name' => $Postdata['name'],
            'role_name' => SlugMaker($Postdata['name']),
            'dashbaord_cards_rights' => $dashboard_cards_rights,
            'type'=> Roles::ROLE_TYPE_NAME,
        ];


        /*ipdating data*/
        $this->roleRepository->update($role,$update_data);

        /*return data */
        return redirect()
            ->route('role.index')
            ->with('success', 'Role updated successfully.');

    }

    /**
     * show action
     *
     */
    public function show(Roles $role)
    {


        $permissions =  Permissions::GetAllPermissions();
        $route_names = $role->Permissions->pluck('route_name')->toArray();

        return view('front.roles.show',compact(
            'role',
            'route_names',
            'permissions'
        ));
    }


}
