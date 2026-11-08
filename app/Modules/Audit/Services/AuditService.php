<?php

namespace App\Modules\Audit\Services;

use App\Modules\Audit\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class AuditService
{
    public static function record(
        string $action,
        ?Model $subject = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $reason = null,
    ): ActivityLog {
        return ActivityLog::create([
            'actor_user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'old_values' => self::scrub($oldValues),
            'new_values' => self::scrub($newValues),
            'reason' => $reason,
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 500),
            'request_id' => (string) Str::uuid(),
            'created_at' => now(),
        ]);
    }

    protected static function scrub(?array $data): ?array
    {
        if ($data === null) return null;
        foreach (['password', 'password_confirmation', 'remember_token', 'api_token'] as $k) {
            if (array_key_exists($k, $data)) $data[$k] = '[REDACTED]';
        }
        return $data;
    }
}