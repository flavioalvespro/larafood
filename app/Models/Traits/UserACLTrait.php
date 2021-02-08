<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait UserACLTrait
{
    public function permissions()
    {
        $permissionsPlan = $this->permissionsPlan();
        $permissionsRole = $this->permissionsRole();

        $permissions = [];

        foreach ($permissionsRole as $permission) {
            if (in_array($permission, $permissionsPlan)) {
                $permissions[] = $permission;
            }
        }

        return $permissions;
    }

    public function permissionsPlan()
    {
        $tenant = Tenant::with('plan.profiles.permissions')->where('id', $this->tenant_id)->first();
        $plan = $tenant->plan;

        $permissions = [];

        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }

    public function permissionsRole()
    {
        $roles = $this->roles()->with('permissions')->get();

        $permissions = [];

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }

    public function hasPermission(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissions());
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, config('acl.admins'));
    }

    public function isTenant(): bool
    {
        return !in_array($this->email, config('acl.admins'));
    }
}