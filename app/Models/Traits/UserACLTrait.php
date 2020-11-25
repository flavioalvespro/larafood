<?php

namespace App\Models\Traits;

trait UserACLTrait
{
    public function permissions()
    {
        $tenant = $this->tenant()->first();
        $plan = $tenant->plan;
        
        $permissions = [];

        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }
}