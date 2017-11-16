<?php


Breadcrumbs::register('admin.user.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('User List', route('admin.user.index'));
});


Breadcrumbs::register('admin.user.create', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Manage Users', route('admin.user.index'));
    $breadcrumbs->push('Create New');
});


Breadcrumbs::register('admin.user.update', function($breadcrumbs, $user) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Manage Users', route('admin.user.index'));
    $breadcrumbs->push($user->username, route('admin.user.view', $user->id));
    $breadcrumbs->push('Update');
});

// ACL

Breadcrumbs::register('admin.acl.role.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Roles');
});

Breadcrumbs::register('admin.acl.role.create', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Roles', route('admin.acl.role.index'));
    $breadcrumbs->push('Create New');
});

Breadcrumbs::register('admin.acl.role.edit', function($breadcrumbs, $role) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Roles', route('admin.acl.role.index'));
    $breadcrumbs->push('Update');
    $breadcrumbs->push($role->name);
});

Breadcrumbs::register('admin.acl.permission.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Permissions');
});

Breadcrumbs::register('admin.acl.permission.create', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Permissions', route('admin.acl.permission.index'));
    $breadcrumbs->push('Create New');
});

Breadcrumbs::register('admin.acl.permission.edit', function($breadcrumbs, $role) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Permissions', route('admin.acl.permission.index'));
    $breadcrumbs->push('Update');
    $breadcrumbs->push($role->name);
});

Breadcrumbs::register('admin.acl.role.permissions', function($breadcrumbs, $role) {
    $breadcrumbs->push('Dashboard', route('admin'));
    $breadcrumbs->push('Roles', route('admin.acl.role.index'));
    $breadcrumbs->push($role->name, route('admin.acl.role.edit', $role->id));
    $breadcrumbs->push('Permissions', route('admin.acl.permission.index'));
});