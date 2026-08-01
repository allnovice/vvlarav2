<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\AssetHistory;
use App\Models\MaintenancePhoto;
use App\Services\ImageService;

class MaintenanceExecutionController extends Controller
{
    public function perform(Request $request, Asset $asset, ImageService $imageService)
    {

abort_unless(auth()->user()->isTechnician(), 403);

$schedule = $asset->maintenanceSchedule;

if ($schedule) {
    $validated = $request->validate([
        'remarks' => ['nullable', 'string'],
        'photos' => ['nullable', 'array'],
        'photos.*' => ['image', 'max:5120'],
    ]);
} else {
    $validated = $request->validate([
        'frequency' => ['required', 'string'],
        'remarks' => ['nullable', 'string'],
        'photos' => ['nullable', 'array'],
        'photos.*' => ['image', 'max:5120'],
    ]);
}

$validated['performed_at'] = today()->toDateString();

if ($schedule) {
    $validated['frequency'] = $schedule->frequency;
} else {
    $schedule = $asset->maintenanceSchedule()->make();
    $schedule->created_by = auth()->id();
    $schedule->frequency = $validated['frequency'];
}

$schedule->maintenance_date = $validated['performed_at'];

$date = \Carbon\Carbon::parse($validated['performed_at']);

$schedule->next_due_date = match ($schedule->frequency) {
    'Weekly' => $date->copy()->addWeek(),
    'Monthly' => $date->copy()->addMonth(),
    'Quarterly' => $date->copy()->addMonths(3),
    'Semi-Annual' => $date->copy()->addMonths(6),
    'Annual' => $date->copy()->addYear(),
    'Custom' => $date->copy()->addDays($schedule->custom_interval),
    default => $date,
};

$schedule->updated_by = auth()->id();
$schedule->save();
$history = AssetHistory::create([
    'asset_id' => $asset->id,
    'type' => 'maintenance',
    'title' => 'Preventive Maintenance',
    'performed_by' => auth()->user()->name,
    'performed_at' => now(),
    'remarks' => $validated['remarks'] ?? null,
]);
if ($request->hasFile('photos')) {

    foreach ($request->file('photos') as $file) {

        $photoPath = $file->store('maintenance', 'public');

        $thumbPath = 'maintenance/thumbs/' . basename($photoPath);

        $imageService->generateThumbnail(
            $photoPath,
            $thumbPath
        );

        MaintenancePhoto::create([
            'asset_history_id' => $history->id,
            'photo_path' => $photoPath,
            'photo_thumb_path' => $thumbPath,
        ]);
    }
}
return back()->with('success', 'Maintenance recorded.');
    }
}
