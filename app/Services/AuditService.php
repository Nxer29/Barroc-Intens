<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuditService
{
    /**
     * Log an action to the audit log
     * 
     * @param string $action The action performed (e.g., 'created', 'updated', 'deleted')
     * @param string $entity The entity type (e.g., 'Product', 'Customer', 'Invoice')
     * @param int|string $entityId The ID of the entity
     * @param int|null $userId Optional: User ID performing the action (defaults to current user)
     * @return AuditLog The created audit log entry
     */
    public static function log(string $action, string $entity, int|string $entityId, ?int $userId = null): AuditLog
    {
        $userId = $userId ?? Auth::id();

        return AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'timestamp' => Carbon::now(),
        ]);
    }

    /**
     * Log a creation action
     */
    public static function logCreated(string $entity, int|string $entityId, ?int $userId = null): AuditLog
    {
        return self::log('created', $entity, $entityId, $userId);
    }

    /**
     * Log an update action
     */
    public static function logUpdated(string $entity, int|string $entityId, ?int $userId = null): AuditLog
    {
        return self::log('updated', $entity, $entityId, $userId);
    }

    /**
     * Log a deletion action
     */
    public static function logDeleted(string $entity, int|string $entityId, ?int $userId = null): AuditLog
    {
        return self::log('deleted', $entity, $entityId, $userId);
    }
}
