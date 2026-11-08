<?php

namespace App\Modules\Identity\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $u): bool { return $u->can('users.view'); }
    public function view(User $u, User $t): bool { return $u->can('users.view') || $u->id === $t->id; }
    public function create(User $u): bool { return $u->can('users.create'); }
    public function update(User $u, User $t): bool { return $u->can('users.update'); }
    public function delete(User $u, User $t): bool { return $u->can('users.delete') && $u->id !== $t->id; }
}