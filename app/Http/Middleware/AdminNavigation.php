<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Menu;

class AdminNavigation
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Menu::make('AdminNav', function($menu){

            $menu->add('Dashboard', ['route' => 'admin'])
                    ->prepend('<i class="fa fa-home"></i> <span class="nav-label">')
                    ->append('</span>');
//                    ->data('permission', 'access.admin.dashboard');
            
            $users = $menu->add('Manage Users', '#')
                    ->prepend('<i class="fa fa-user"></i> <span class="nav-label">')
                    ->append('</span>')
                    ->active('admin.user.*');
            $users->add('List All', ['route' => 'admin.user.index'])
                    ->active('admin.user.index');
            $users->add('Create New',  ['route' => 'admin.user.create'])
                    ->active('admin.user.create');
            
            //ACL
            $acl = $menu->add('ACL', '#')
                    ->prepend('<i class="fa fa-gavel"></i> <span class="nav-label">')
                    ->append('</span>')
                    ->active('admin.acl.*');
            
            $acl->add('Roles',  ['route' => 'admin.acl.role.index'])
                    ->active('admin.acl.role.index');
            
            $acl->add('Permissions',  ['route' => 'admin.acl.permission.index'])
                    ->active('admin.acl.permission.index');
            
           

        });

       
        return $next($request);
    }

}
