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

        $nextDue = match ($validated['frequency']) {
            'Weekly' => now()->parse($validated['maintenance_date'])->addWeek(),
            'Monthly' => now()->parse($validated['maintenance_date'])->addMonth(),
            'Quarterly' => now()->parse($validated['maintenance_date'])->addMonths(3),
            'Semi-Annual' => now()->parse($validated['maintenance_date'])->addMonths(6),
            'Annual' => now()->parse($validated['maintenance_date'])->addYear(),
            'Custom' => now()->parse($validated['maintenance_date'])
                ->addDays($validated['custom_interval']),
        };

        $asset->maintenanceSchedule()->create([
            ...$validated,
            'next_due_date' => $nextDue,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Maintenance schedule created.');
    }
    public function update(Request $request, Asset $asset)
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
            'Daily' => $date->copy()->addDay(),
            'Weekly' => $date->copy()->addWeek(),
            'Monthly' => $date->copy()->addMonth(),
            'Quarterly' => $date->copy()->addMonths(3),
            'Semi-Annual' => $date->copy()->addMonths(6),
            'Annual' => $date->copy()->addYear(),
            'Custom' => $date->copy()->addDays($validated['custom_interval']),
            default => $date,
        };

        $asset->maintenanceSchedule()->update([
            ...$validated,
            'next_due_date' => $nextDue,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Maintenance schedule updated.');
    }
    public function destroy(Asset $asset)
    {
        abort_unless(Auth::user()->isITHead(), 403);
        
        $asset->maintenanceSchedule()->delete();

        return back()->with('success', 'Maintenance schedule deleted.');
    }
}
