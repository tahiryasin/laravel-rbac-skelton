<?php
/*
 * Override Kodeine\Acl\Traits\HasRole
 * Existing trait returns user roles from cache causing admin not see his changes immediately
 */

namespace App\Overrides;
use Kodeine\Acl\Traits\HasRole;

trait HasRoleOverride
{

    use HasRole;

    /**
     * Get all roles.
     *
     * @return array
     */
    public function getRoles()
    {
        $this_roles = $this->roles;

        $slugs = method_exists($this_roles, 'pluck') ? $this_roles->pluck('slug', 'id') : $this_roles->lists('slug', 'id');
        return is_null($this_roles) ? [] : $this->collectionAsArray($slugs);
    }

}
