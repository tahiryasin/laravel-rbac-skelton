<?php

/*
 * Override Kodeine\Acl\Models\Eloquent\Role to overcome cache issue
 * 
 */

namespace App\Overrides;

use Kodeine\Acl\Models\Eloquent\Role as KodeineRole;


class Role extends KodeineRole
{

    
    /**
     * List all permissions
     *
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->getPermissionsInherited();
    }

}
