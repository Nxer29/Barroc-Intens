<?php

namespace App\Traits;

use App\Services\AuditService;

/**
 * Trait Auditable
 * 
 * This trait can be added to any model to automatically log
 * create, update, and delete actions to the audit log.
 * 
 * Usage:
 * - Add `use Auditable;` to your model
 * - Override the $auditableEntity property if needed (defaults to class name)
 * 
 * Example:
 * class Customer extends Model {
 *     use Auditable;
 * }
 */
trait Auditable
{
    /**
     * The entity name to use in audit logs (defaults to class name)
     */
    protected string $auditableEntity = '';

    /**
     * Boot the trait
     */
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            $entity = $model->getAuditableEntity();
            AuditService::logCreated($entity, $model->getKey());
        });

        static::updated(function ($model) {
            $entity = $model->getAuditableEntity();
            AuditService::logUpdated($entity, $model->getKey());
        });

        static::deleted(function ($model) {
            $entity = $model->getAuditableEntity();
            AuditService::logDeleted($entity, $model->getKey());
        });
    }

    /**
     * Get the entity name for audit logging
     */
    protected function getAuditableEntity(): string
    {
        return $this->auditableEntity ?: class_basename($this);
    }
}
