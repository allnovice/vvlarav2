<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\MaintenanceSchedule;

class SeedMaintenanceDemo extends Command
{
protected $signature = 'cmms:seed-maintenance-demo {--reset : Reset maintenance demo data only}';
protected $description = 'Generate demo maintenance schedules for development.';
    public function handle()
    {

if (app()->environment('production')) {
    $this->error('This command cannot be run in production.');
    return self::FAILURE;
}
$count = Asset::count();

$this->info("Found {$count} assets.");

$assets = Asset::orderBy('id')->get();

if ($this->option('reset')) {

    MaintenanceSchedule::query()->delete();

    $this->info("Reset maintenance schedules for {$assets->count()} assets.");

    return self::SUCCESS;
}

if (! $this->confirm('Generate demo maintenance schedules?')) {
    $this->warn('Cancelled.');

    return self::SUCCESS;
}

$this->info("Preparing {$assets->count()} assets...");

MaintenanceSchedule::query()->delete();

$today = today();

$neverMaintained = 0;
$overdue = 0;
$dueSoon = 0;
$healthy = 0;

foreach ($assets as $index => $asset) {

if ($index < 35) {
    $neverMaintained++;
    continue;
}
if ($index < 60) {

    $overdue++;

    MaintenanceSchedule::create([
        'asset_id' => $asset->id,
        'maintenance_date' => $today->copy()->subMonths(6),
        'frequency' => 'Semi-Annual',
        'next_due_date' => $today->copy()->subDays(rand(1, 60)),
        'created_by' => 1,
    ]);

    continue;
}
if ($index < 100) {

    $dueSoon++;

    MaintenanceSchedule::create([
        'asset_id' => $asset->id,
        'maintenance_date' => $today->copy()->subMonths(5),
        'frequency' => 'Semi-Annual',
        'next_due_date' => $today->copy()->addDays(rand(1, 30)),
        'created_by' => 1,
    ]);

    continue;
}
$healthy++;

MaintenanceSchedule::create([
    'asset_id' => $asset->id,
    'maintenance_date' => $today->copy()->subMonths(rand(1, 5)),
    'frequency' => 'Semi-Annual',
    'next_due_date' => $today->copy()->addDays(rand(31, 180)),
    'created_by' => 1,
]);

}

$this->newLine();

$this->table(
    ['Status', 'Count'],
    [
        ['Never Maintained', $neverMaintained],
        ['Overdue', $overdue],
        ['Due Soon', $dueSoon],
        ['Healthy', $healthy],
    ]
);

return self::SUCCESS;

    }
}
