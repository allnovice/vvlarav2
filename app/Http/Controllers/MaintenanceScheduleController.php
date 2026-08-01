<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MaintenanceScheduleController extends Controller
{
public function store(Request $request, Asset $asset)
{
    abort_unless(Auth::user()->isITHead(), 403);

    $validated = $request->validate([
        'maintenance_date' => ['required', 'date'],
        'frequency' => ['required', 'string'],
        'custom_interval' => ['nullable', 'integer', 'min:1'],
        'notes' => ['nullable', 'string'],
    ]);

    $date = Carbon::parse($validated['maintenance_date']);

    $nextDue = match ($validated['frequency']) {
        'Weekly' => $date->copy()->addWeek(),
        'Monthly' => $date->copy()->addMonth(),
        'Quarterly' => $date->copy()->addMonths(3),
        'Semi-Annual' => $date->copy()->addMonths(6),
        'Annual' => $date->copy()->addYear(),
        'Custom' => $date->copy()->addDays($validated['custom_interval']),
        default => $date,
    };

    MaintenanceSchedule::create([
        'asset_id' => $asset->id,
        'maintenance_date' => $validated['maintenance_date'],
        'frequency' => $validated['frequency'],
        'custom_interval' => $validated['custom_interval'],
        'next_due_date' => $nextDue,
        'notes' => $validated['notes'],
        'created_by' => Auth::id(),
    ]);

    return back()->with('success', 'Maintenance schedule created.');
}

    public function update(Request $request, Asset $asset)
    {
        // validate

        // calculate next_due_date

        // update schedule

        // return success
    }

    public function destroy(Asset $asset)
    {
        // delete schedule
    }
}
