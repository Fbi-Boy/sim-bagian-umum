<?php

namespace App\Modules\Organization\Policies;

use App\Models\User;
use App\Modules\Organization\Models\OrganizationalUnit;

class OrganizationalUnitPolicy
{
    public function viewAny(User $u): bool { return $u->can('organization.units.view'); }
    public function view(User $u, OrganizationalUnit $unit): bool { return $u->can('organization.units.view'); }
    public function create(User $u): bool { return $u->can('organization.units.create'); }
    public function update(User $u, OrganizationalUnit $unit): bool { return $u->can('organization.units.update'); }
    public function delete(User $u, OrganizationalUnit $unit): bool
    {
        return $u->can('organization.units.delete') && ! $unit->assignments()->exists();
    }
}