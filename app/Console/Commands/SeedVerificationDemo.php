<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\AssetVerification;

class SeedVerificationDemo extends Command
{
    protected $signature = 'cmms:seed-verification-demo {--reset : Reset verification data only}';

    protected $description = 'Generate demo verification data for development.';

public function handle(): int
{
    if (app()->environment('production')) {
        $this->error('This command cannot be run in production.');
        return self::FAILURE;
    }

    $count = Asset::count();

    $this->info("Found {$count} assets.");

    $assets = Asset::orderBy('id')->get();

if ($this->option('reset')) {

    AssetVerification::query()->delete();

    foreach ($assets as $asset) {
        $asset->update([
            'verified_at' => null,
            'last_verified_at' => null,
            'next_verification_due' => null,
            'verified_by' => null,
        ]);
    }

    $this->info("Reset verification data for {$assets->count()} assets.");

    return self::SUCCESS;
}

    if (! $this->confirm('Generate demo verification data?')) {
        $this->warn('Cancelled.');
        return self::SUCCESS;
    }

    $this->info("Preparing {$assets->count()} assets...");

    // Start from a clean state


    $today = now();

    $neverVerified = 0;
    $overdue = 0;
    $due = 0;
    $verified = 0;

    foreach ($assets as $index => $asset) {

        // 1-15 : Never Verified
        if ($index < 15) {
            $neverVerified++;
            continue;
        }

        // 16-33 : Overdue
        if ($index < 33) {

            $overdue++;

            $lastVerified = $today->copy()->subMonths(6)->subDays(rand(1, 60));


$asset->update([
    'verified_at' => $lastVerified,
    'last_verified_at' => $lastVerified,
    'next_verification_due' => $today->copy()->subDays(rand(1, 60)),
    'verified_by' => 1,
]);

$this->createVerificationHistory($asset, $lastVerified);

continue;
        }

        // 34-70 : Due within 30 days
        if ($index < 70) {

            $due++;

            $lastVerified = $today->copy()->subMonths(6)->addDays(rand(1, 30));

$asset->update([
    'verified_at' => $lastVerified,
    'last_verified_at' => $lastVerified,
    'next_verification_due' => $today->copy()->addDays(rand(1, 30)),
    'verified_by' => 1,
]);

$this->createVerificationHistory($asset, $lastVerified);

continue;
        }

        // Remaining : Verified
        $verified++;

        $lastVerified = $today->copy()->subMonths(rand(0, 5));

$asset->update([
    'verified_at' => $lastVerified,
    'last_verified_at' => $lastVerified,
    'next_verification_due' => $today->copy()->addDays(rand(31, 180)),
    'verified_by' => 1,
]);

$this->createVerificationHistory($asset, $lastVerified);
    }

    $this->newLine();

    $this->info('Demo verification data generated.');

    $this->table(
        ['Status', 'Count'],
        [
            ['Never Verified', $neverVerified],
            ['Overdue', $overdue],
            ['Due (30 Days)', $due],
            ['Verified', $verified],
        ]
    );

    return self::SUCCESS;
}
private function createVerificationHistory(Asset $asset, $lastVerified): void
{
    AssetVerification::create([
        'asset_id' => $asset->id,
        'user_id' => 1,
        'status' => AssetVerification::STATUS_APPROVED,
        'reviewed_by' => 1,
        'reviewed_at' => $lastVerified,
        'created_at' => $lastVerified,
        'updated_at' => $lastVerified,
    ]);
}
}
