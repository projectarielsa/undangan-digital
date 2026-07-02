<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            static::logActivity("created", $model);
        });

        static::updated(function ($model) {
            static::logActivity("updated", $model);
        });

        static::deleted(function ($model) {
            static::logActivity("deleted", $model);
        });
    }

    public static function logActivity(string $action, Model $model, array $properties = []): void
    {
        if (!auth()->check()) return;

        ActivityLog::create([
            "user_id" => auth()->id(),
            "action" => $action,
            "subject_type" => get_class($model),
            "subject_id" => $model->id,
            "properties" => array_merge($properties, [
                "model_class" => get_class($model),
            ]),
        ]);
    }
}
