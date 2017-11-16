<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;
use App\Overrides\Datatables;
use Validator;
use Route;
use Helper;

class PermissionController extends Controller
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    'name' => 'required|min:4|max:255',
//                    'slug' => 'required|min:4|max:255',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.acl.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.acl.permission.create')->withPermission(new Permission);
    }

    /**
     * Show the form for generating bulk permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        $permissions = Permission::select(['name', 'slug'])->get()->toArray();
        $permissions_array = [];
        foreach ($permissions as $key => $permission) {
            $action = $permission['slug'];
            $name = $permission['name'];

            reset($action);
            $action = key($action);
            $permissions_array[] = $action . "." . $name;
        }

        $routes = Route::getRoutes()->getRoutes();
        $controllers = [];
        $i = 0;
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action)) {
                $controller = class_basename($action['controller']);
                list($controller, $action) = explode('@', $controller);
                $controller = strtolower(str_replace('Controller', null, $controller));
                if (!in_array($action . "." . $controller, $permissions_array))
                    $controllers[$controller][] = $action;
                $i++;
            }
        }
        return view('admin.acl.permission.generate')->withControllers($controllers);
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
        if (empty($data['permission'])) {
            $validator = $this->validator($data);
            if ($validator->fails()) {
                return redirect(route('admin.acl.permission.create'))->withInput()->withErrors($validator);
            }

            if (count(explode('.', $data['name'])) != 2) {
                return redirect(route('admin.acl.permission.create'))->withInput()->withErrors('Invalid permission name');
            }

            list($name, $action) = explode('.', $data['name']);
            $permission = new Permission();
            $permission->name = $name;
            $permission->slug = [$action => true];
            $permission->save();
            $message = 'Permission successfully created.';
        } else {
            foreach ($data['permission'] as $controller => $actions) {
                foreach ($actions as $action => $value) {
                    $permission = new Permission();
                    $permission->name = strtolower($controller);
                    $permission->slug = [$action => true];
                    $permission->save();
                }
            }
            $message = 'Permissions generated created.';
        }
        return redirect(route('admin.acl.permission.index'))->with('success', $message);
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
    public function edit(Permission $permission)
    {
        $slug = $permission->slug;
        reset($slug);
        $action = key($slug);

        $permission->name = $action . "." . $permission->name;
        return view('admin.acl.permission.update')->withPermission($permission);
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
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect(route('admin.acl.permission.edit', $id))->withInput()->withErrors($validator);
        }

        if (count(explode('.', $data['name'])) != 2) {
            return redirect(route('admin.acl.permission.edit', $id))->withInput()->withErrors('Invalid permission name');
        }

        list($action, $name) = explode('.', $data['name']);
        $permission = Permission::find($id);
        $permission->name = $name;
        $permission->slug = [$action => true];
        $permission->save();

        return redirect(route('admin.acl.permission.edit', $id))->with('success', 'Permission successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect(route('admin.acl.permission.index'))->with('success', 'Permission successfully deleted.');
    }

    /**
     * Provide data to grid
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $permissions = Permission::all();
        return Datatables::of($permissions)
                        ->addColumn('action', function ($permission) {
                            return '<a href="' . Route('admin.acl.permission.edit', ['id' => $permission->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>'
                                    . ' <a href="#" onclick="event.preventDefault();document.getElementById(\'delete-form-' . $permission->id . '\').click();" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
                                    . '<form onsubmit="return confirm(\'Are you sure?\');"  action="' . Route('admin.acl.permission.delete', [$permission->id]) . '" method="POST" style="display:none;" >
                                   ' . csrf_field() . '
                                <input id="delete-form-' . $permission->id . '" type="submit" ></form>';
                        })
                        ->editColumn('name', function ($permission) {
                            $action = $permission->slug;
                            reset($action);
                            $action = key($action);
                            return $action.".".$permission->name;
                        })
                        ->make(true);
    }

}
