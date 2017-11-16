<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;
use App\Overrides\Role as OverridenRole;
use Yajra\Datatables\Datatables;
use Validator;

class RoleController extends Controller
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id = null)
    {
        if (!$id)
            return Validator::make($data, [
                        'name' => 'required|min:4|max:255|unique:roles',
                        'slug' => 'required|min:4|max:255|unique:roles',
            ]);

        return Validator::make($data, [
                    'name' => 'required|min:4|max:255|unique:roles' . ($id ? ",name,$id" : ''),
                    'slug' => 'required|min:4|max:255|unique:roles' . ($id ? ",slug,$id" : ''),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.acl.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.acl.role.create')->withRole(new Role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect(route('admin.acl.role.create'))->withInput()->withErrors($validator);
        }

        $role = new Role();
        $role->fill($data);
        $role->save();
        return redirect(route('admin.acl.role.index'))->with('success', 'Role successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.acl.role.update')->withRole($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = $this->validator($data, $id);
        if ($validator->fails()) {
            return redirect(route('admin.acl.role.edit', $id))->withInput()->withErrors($validator);
        }

        $role = Role::find($id);
        $role->fill($data);
        $role->save();
        return redirect(route('admin.acl.role.edit', $id))->with('success', 'Role successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect(route('admin.acl.role.index'))->with('success', 'Role successfully deleted.');
    }

    /**
     * Provide data to grid
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $roles = Role::all();
        return Datatables::of($roles)
                        ->addColumn('action', function ($role) {
                            return '<a href="' . Route('admin.acl.role.edit', ['id' => $role->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>'
                                    . ' <a href="' . Route('admin.acl.role.permissions', ['id' => $role->id]) . '" class="btn btn-xs btn-primary"><i class="fa fa-ban"></i> Manage Permissions</a>'
                                    . ' <a href="#" onclick="event.preventDefault();document.getElementById(\'delete-form-' . $role->id . '\').click();" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
                                    . '<form onsubmit="return confirm(\'Are you sure?\');"  action="' . Route('admin.acl.role.delete', [$role->id]) . '" method="POST" style="display:none;" >
                                   ' . csrf_field() . '
                                <input id="delete-form-' . $role->id . '" type="submit" ></form>';
                        })
//                        ->editColumn('id', 'ID: {{$id}}')
                        ->make(true);
    }

    public function permissions(OverridenRole $role)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        $p_array = [];
        foreach ($permissions as $permission) {
            $slug = $permission->slug;
            reset($slug);
            $action = key($slug);
            $p_array[ucfirst($permission->name)][$action] = [
                'status' => $role->can($action . '.' . $permission->name),
                'id' => $permission->id
            ];
        }
//        dd($p_array);
        return view('admin.acl.role.permissions')->withPermissions($p_array)->withRole($role);
    }

    public function store_permissions(Role $role, Request $request)
    {
        $permissions = [];
        if (!empty($request->permission))
            $permissions = array_keys($request->permission);
        $role->syncPermissions($permissions);
        return redirect(route('admin.acl.role.permissions', $role->id))->with('success', 'Permissions successfully updated.');
    }

}
