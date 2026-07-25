<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;
use App\Models\AssetChange;

class ActivityLogger
{

public const ACTION_SUBMIT_CREATE = 'Submit Create';
public const ACTION_SUBMIT_UPDATE = 'Submit Update';
public const ACTION_SUBMIT_DELETE = 'Submit Delete';

public const ACTION_APPROVE_CREATE = 'Approve Create';
public const ACTION_APPROVE_UPDATE = 'Approve Update';
public const ACTION_APPROVE_DELETE = 'Approve Delete';

public const ACTION_REJECT = 'Reject';

    public function log(
        string $module,
        string $action,
        string $description,
        ?Model $subject = null,
        ?array $properties = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'module' => $module,
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'properties' => $properties,
        ]);
    }

public function logAsset(
    string $action,
    string $description,
    ?Asset $asset,
    AssetChange $change
): ActivityLog {
    return $this->log(
        'Assets',
        $action,
        $description,
        $asset,
        [
            'asset_change_id' => $change->id,
            'property_number' => $asset?->property_number
                ?? ($change->data['property_number'] ?? null),
            'request_action' => $change->action,
        ]
    );
}




}
