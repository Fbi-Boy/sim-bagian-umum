<?php

namespace App\Modules\Identity\Actions;

use App\Models\User;
use App\Modules\Audit\Services\AuditService;
use App\Modules\Identity\Models\Role;
use App\Modules\Identity\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssignRoleToUser
{
    public function handle(User $target, array $data, User $grantedBy): UserRole
    {
        return DB::transaction(function () use ($target, $data, $grantedBy) {
            $role = Role::where('id', $data['role_id'])->where('is_active', true)->firstOrFail();

            $overlap = UserRole::where('user_id', $target->id)
                ->where('role_id', $role->id)
                ->whereNull('revoked_at')
                ->where(fn ($q) => $q->whereNull('valid_until')->orWhere('valid_until', '>', $data['valid_from']))
                ->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'role_id' => 'User sudah memiliki role aktif ini pada periode yang overlap.',
                ]);
            }

            $ur = UserRole::create([
                'user_id' => $target->id,
                'role_id' => $role->id,
                'scope_unit_id' => $data['scope_unit_id'] ?? null,
                'valid_from' => $data['valid_from'],
                'valid_until' => $data['valid_until'] ?? null,
                'granted_by' => $grantedBy->id,
                'grant_reason' => $data['grant_reason'] ?? null,
            ]);

            AuditService::record(
                action: 'identity.role.assigned',
                subject: $ur,
                newValues: $ur->toArray(),
                reason: $data['grant_reason'] ?? null,
            );

            return $ur;
        });
    }
}