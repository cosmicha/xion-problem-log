<?php

namespace App\Support;

use App\Models\ProblemLog;
use App\Models\ProblemLogUpdate;

class ProblemLogActivity
{
    public static function add(
        ProblemLog $problemLog,
        string $type,
        ?string $message = null,
        ?string $oldStatus = null,
        ?string $newStatus = null,
        ?array $meta = null,
        ?int $userId = null
    ): ProblemLogUpdate {
        return ProblemLogUpdate::create([
            'problem_log_id' => $problemLog->id,
            'user_id' => $userId ?? auth()->id(),
            'type' => $type,
            'message' => $message,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'meta' => $meta,
        ]);
    }
}
