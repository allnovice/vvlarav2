<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\AssetHistoryChange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetHistoryChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_history_change(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $change = AssetHistoryChange::create([
            'asset_id' => $asset->id,
            'user_id' => $employee->id,
            'type' => 'repair',
            'title' => 'Screen repaired',
            'description' => 'Replaced damaged screen.',
            'performed_by' => 'Technician',
            'performed_at' => now(),
            'remarks' => 'Completed successfully.',
            'status' => AssetHistoryChange::STATUS_PENDING,
        ]);

        $this->actingAs($admin)
            ->post(route('asset-history-changes.approve', $change))
            ->assertRedirect(route('asset-history-changes.index'));

        $this->assertDatabaseHas('asset_history_changes', [
            'id' => $change->id,
            'status' => AssetHistoryChange::STATUS_APPROVED,
            'approved_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('asset_histories', [
            'asset_id' => $asset->id,
            'asset_history_change_id' => $change->id,
            'title' => 'Screen repaired',
        ]);
    }

    public function test_admin_can_reject_history_change(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $change = AssetHistoryChange::create([
            'asset_id' => $asset->id,
            'user_id' => $employee->id,
            'type' => 'repair',
            'title' => 'Screen repaired',
'performed_by' => 'Technician',
'performed_at' => now(),
            'status' => AssetHistoryChange::STATUS_PENDING,
        ]);

        $this->actingAs($admin)
            ->post(route('asset-history-changes.reject', $change))
            ->assertRedirect(route('asset-history-changes.index'));

        $this->assertDatabaseHas('asset_history_changes', [
            'id' => $change->id,
            'status' => AssetHistoryChange::STATUS_REJECTED,
            'approved_by' => $admin->id,
        ]);

        $this->assertDatabaseMissing('asset_histories', [
            'asset_history_change_id' => $change->id,
        ]);
    }
public function test_user_cannot_approve_their_own_history_change(): void
{
    $user = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $change = AssetHistoryChange::create([
        'asset_id' => $asset->id,
        'user_id' => $user->id,
        'type' => 'repair',
        'title' => 'Screen repaired',
        'performed_by' => 'Technician',
        'performed_at' => now(),
        'status' => AssetHistoryChange::STATUS_PENDING,
    ]);

    $this->actingAs($user)
        ->post(route('asset-history-changes.approve', $change))
        ->assertSessionHasErrors('change');

    $this->assertDatabaseHas('asset_history_changes', [
        'id' => $change->id,
        'status' => AssetHistoryChange::STATUS_PENDING,
    ]);
}
public function test_employee_cannot_approve_history_change(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $requester = User::factory()->create(['role' => 'employee']);
    $asset = Asset::factory()->create();

    $change = AssetHistoryChange::create([
        'asset_id' => $asset->id,
        'user_id' => $requester->id,
        'type' => 'repair',
        'title' => 'Screen repaired',
        'performed_by' => 'Technician',
        'performed_at' => now(),
        'status' => AssetHistoryChange::STATUS_PENDING,
    ]);

    $this->actingAs($employee)
        ->post(route('asset-history-changes.approve', $change))
        ->assertForbidden();

    $this->assertDatabaseHas('asset_history_changes', [
        'id' => $change->id,
        'status' => AssetHistoryChange::STATUS_PENDING,
    ]);
}
public function test_processed_history_change_cannot_be_approved_again(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $admin = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $change = AssetHistoryChange::create([
        'asset_id' => $asset->id,
        'user_id' => $employee->id,
        'type' => 'repair',
        'title' => 'Screen repaired',
        'performed_by' => 'Technician',
        'performed_at' => now(),
        'status' => AssetHistoryChange::STATUS_APPROVED,
        'approved_by' => $admin->id,
        'approved_at' => now(),
    ]);

    $this->actingAs($admin)
        ->post(route('asset-history-changes.approve', $change))
        ->assertSessionHasErrors('change');

    $this->assertDatabaseCount('asset_histories', 0);
}
}
