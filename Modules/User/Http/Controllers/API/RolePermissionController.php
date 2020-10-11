<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ModuleList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Role', ['except' => ['getAllRoles', 'getUserPermissions']]);
        //  $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['updateRole', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {

            $role = Role::orderBy('id', 'ASC')->get();
            $modulePermission = ModuleList::with('modulePermission')
                ->get();
            return [
                'role' => $role,
                'modulePermission' => $modulePermission,
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storeRole(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        try {
            $role = Role::create(['name' => $request->input('name')]);
            return ['success' => $role];

        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $role = Role::find($id);
            return $role->load('permissions');
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateRole(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        try {
            $role = Role::findorFail($id);
            if ($role->update($request->all())) {
                return ["message" => "Updated the role info"];
            } else {

            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store role permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function syncPermissionToRole(Request $request)
    {
        try {
            $role = Role::find($request['role']);
            if ($role->syncPermissions($request['permissions'])) {
                return ["message" => "Permissions sync to role"];
            } else {

            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroyRole($id)
    {
        try {
            $role = Role::findOrFail($id);

            //delete the role
            if ($role->delete()) {
                return ['message' => 'Role deleted successfully'];
            } else {

            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserPermissions(Request $request)
    {
        try {
            $userRoles = $request->user()->roles;
            $permissions = [];
            foreach ($userRoles as $key => $value) {
                $role = Role::find($value['id']);
                $permissionsTemp = $role->load('permissions');
                array_push($permissions, $permissionsTemp);
            }
            return [
                'data' => $permissions,
                'status' => \Config::get('utils_constants.SUCCESS'),
            ];
        } catch (Exception $e) {
            return $e->getMessage();

        }
    }
    /**
     * @author Iqbal
     * @date 
     * get all roles list
     * @param int $id
     * @return Response
     */
    public function getAllRoles()
    {
        try {
            $roles = Role::orderBy('id', 'ASC')->get();
            return [
                'data' => $roles,
                'status' => \Config::get('utils_constants.SUCCESS'),
            ];
        } catch (Exception $e) {
            return [
                'reason' => 'error',
                'message' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR'),
            ];
        }
    }

}
