<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;
class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('admin.dashboard');
    }
    
    public function dashboard()
    {
//        $role = new Role();
//        $roleAdmin = $role->create([
//            'name' => 'Administrator',
//            'slug' => 'administrator',
//            'description' => 'manage administration privileges'
//        ]);
        
//        $user = User::find(1);
//        $user->assignRole('administrator');
        


        return view('home');
    }

}
