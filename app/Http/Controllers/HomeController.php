<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;
class HomeController extends Controller
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
        return view('home');
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
