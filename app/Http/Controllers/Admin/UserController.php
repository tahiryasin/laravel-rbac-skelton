<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;
use Yajra\Datatables\Datatables;
use Route;
use \App\Http\Requests\CreateUserRequest;
use Validator;


class UserController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                        'username' => 'required|min:4|max:255|unique:users',
                        'email' => 'required|email|max:255|unique:users',
                        'password' => 'required|min:6|confirmed',
            ]);

        return Validator::make($data, [
                    'username' => 'required|min:4|max:255|unique:users' . ($id ? ",username,$id" : ''),
                    'email' => 'required|email|max:255|unique:users' . ($id ? ",email,$id" : ''),
                    'password' => 'min:6|confirmed',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(User $user)
    {
        return view('admin.user.view', ['user' => $user]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = $this->validator($data);
            if ($validator->fails()) {
                return redirect($this->route('create'))->withInput()->withErrors($validator);
            }

            $user = User::create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => bcrypt($data['password']),
                        'status' => $data['status']
            ]);

            $user->assignRole($request->role);

            return redirect($this->route('create'))->with('success', 'User successfully created.');
        }

        $roles = Role::all();
        return view('admin.user.create', ['roles' => $roles]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $users = User::select(['id', 'username', 'email', 'password', 'created_at', 'updated_at']);

        return Datatables::of($users)
                        ->addColumn('action', function ($user) {
                            return '<a href="' . Route('admin.user.update', ['id' => $user->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>'
                                    . ' <a href="#" onclick="event.preventDefault();document.getElementById(\'delete-form-' . $user->id . '\').click();" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
                                    . '<form onsubmit="return confirm(\'Are you sure?\');"  action="' . Route('admin.user.delete', [$user->id]) . '" method="POST" style="display:none;" >
                                   ' . csrf_field() . '
                                <input id="delete-form-' . $user->id . '" type="submit" ></form>';
                        })
//                        ->editColumn('id', 'ID: {{$id}}')
                        ->removeColumn('password')
                        ->make(true);
    }

    public function update(User $user, Request $request)
    {
        if ($request->isMethod('post')) {
            
            $validator = $this->validator($request->all(), $user->id);

            if ($validator->fails()) {
                return redirect(route('admin.user.update', $user->id))->withInput()->withErrors($validator);
            }
            
            $data = $request->except('password');
            $user->fill($data);
            $user->save();
            $user->syncRoles($request->role);
            return redirect(route('admin.user.update', $user->id))->with('success', 'User successfully updated.');
        }

        $allRoles = Role::all();
        $userRoles = $user->getRoles(true);
        $roles = [];
        foreach($allRoles as $role)
        {
            $roles[] = [
                'name'=>$role->name,
                'slug'=>$role->slug,
                'status'=> array_key_exists($role->id, $userRoles) ? true : false,
            ];
        }
//        dd($roles);
        return view('admin.user.update', ['user' => $user, 'roles' => $roles]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect($this->route('index'))->with('success', 'User successfully deleted.');
    }

    private function route($action)
    {
        return route('admin.user.' . $action);
    }

}
