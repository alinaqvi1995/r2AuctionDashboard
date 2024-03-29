<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the role permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolePermissions = Role::with('permissions')->get();
        return view('dashboard.admin.role_permissions.index', compact('rolePermissions'));
    }

    /**
     * Show the form for creating a new role permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('dashboard.admin.role_permissions.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->permissions()->sync($request->permission_id);

        return redirect()->route('role_permissions.index')->with('success', 'Role permission created successfully');
    }

    /**
     * Remove the specified role permission from storage.
     *
     * @param  \App\Models\Role  $role
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, Permission $permission)
    {
        dd($role->toArray(), $permission->toArray());
        $role->permissions()->detach($permission->id);
        return redirect()->route('role_permissions.index')->with('success', 'Role permission deleted successfully');
    }
    public function getPermissions(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $all_permissions = Permission::all();
        $permissions = $role->permissions()->get(['id', 'display_name']);

        $html = '<select id="permission_id" name="permission_id[]" class="form-control select2" multiple required>';

        foreach ($all_permissions as $permission) {
            $selected = $permissions->contains('id', $permission->id) ? 'selected' : '';
            $html .= '<option value="' . $permission->id . '" ' . $selected . '>' . $permission->display_name . '</option>';
        }

        $html .= '</select>';

        return response()->json(['html' => $html]);
    }
}
