<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetChange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetChangeApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_asset_creation_request(): void
    {
        $employee = User::factory()->create([
            "role" => "employee",
        ]);

        $admin = User::factory()->create([
            "role" => "admin",
        ]);

        $change = AssetChange::create([
            "user_id" => $employee->id,
            "action" => AssetChange::ACTION_CREATE,
            "status" => AssetChange::STATUS_PENDING,
            "data" => [
                "property_number" => "NCIP-APPROVAL-1001",
                "type" => "Laptop",
                "status" => "Active",
                "description" => "Approval test asset",
            ],
        ]);

        $this->actingAs($admin)
            ->post(route("asset-changes.approve", $change))
            ->assertRedirect(route("asset-changes.index"));

        $this->assertDatabaseHas("assets", [
            "property_number" => "NCIP-APPROVAL-1001",
            "description" => "Approval test asset",
        ]);

        $this->assertDatabaseHas("asset_changes", [
            "id" => $change->id,
            "status" => AssetChange::STATUS_APPROVED,
            "approved_by" => $admin->id,
        ]);
    }
public function test_admin_can_reject_asset_creation_request(): void
{
    $employee = User::factory()->create([
        "role" => "employee",
    ]);

    $admin = User::factory()->create([
        "role" => "admin",
    ]);

    $change = AssetChange::create([
        "user_id" => $employee->id,
        "action" => AssetChange::ACTION_CREATE,
        "status" => AssetChange::STATUS_PENDING,
        "data" => [
            "property_number" => "NCIP-REJECT-1001",
            "type" => "Laptop",
            "status" => "Active",
            "description" => "Rejected test asset",
        ],
    ]);

    $this->actingAs($admin)
        ->post(route("asset-changes.reject", $change))
        ->assertRedirect(route("asset-changes.index"));

    $this->assertDatabaseMissing("assets", [
        "property_number" => "NCIP-REJECT-1001",
    ]);

    $this->assertDatabaseHas("asset_changes", [
        "id" => $change->id,
        "status" => AssetChange::STATUS_REJECTED,
        "approved_by" => $admin->id,
    ]);
}
public function test_admin_can_approve_asset_update_request(): void
{
    $employee = User::factory()->create([
        "role" => "employee",
    ]);

    $admin = User::factory()->create([
        "role" => "admin",
    ]);

    $asset = Asset::factory()->create([
        "description" => "Original description",
    ]);

    $change = AssetChange::create([
        "asset_id" => $asset->id,
        "user_id" => $employee->id,
        "action" => AssetChange::ACTION_UPDATE,
        "status" => AssetChange::STATUS_PENDING,
        "data" => [
            "property_number" => $asset->property_number,
            "type" => $asset->type,
            "status" => $asset->status,
            "description" => "Approved updated description",
        ],
    ]);

    $this->actingAs($admin)
        ->post(route("asset-changes.approve", $change))
        ->assertRedirect(route("asset-changes.index"));

    $this->assertDatabaseHas("assets", [
        "id" => $asset->id,
        "description" => "Approved updated description",
    ]);

    $this->assertDatabaseHas("asset_changes", [
        "id" => $change->id,
        "status" => AssetChange::STATUS_APPROVED,
        "approved_by" => $admin->id,
    ]);
}
public function test_admin_can_approve_asset_deletion_request(): void
{
    $employee = User::factory()->create([
        "role" => "employee",
    ]);

    $admin = User::factory()->create([
        "role" => "admin",
    ]);

    $asset = Asset::factory()->create();

    $change = AssetChange::create([
        "asset_id" => $asset->id,
        "user_id" => $employee->id,
        "action" => AssetChange::ACTION_DELETE,
        "status" => AssetChange::STATUS_PENDING,
        "data" => $asset->toArray(),
    ]);

    $this->actingAs($admin)
        ->post(route("asset-changes.approve", $change))
        ->assertRedirect(route("asset-changes.index"));

    $this->assertDatabaseMissing("assets", [
        "id" => $asset->id,
    ]);

    $this->assertDatabaseHas("asset_changes", [
        "id" => $change->id,
        "status" => AssetChange::STATUS_APPROVED,
        "approved_by" => $admin->id,
    ]);
}
}
