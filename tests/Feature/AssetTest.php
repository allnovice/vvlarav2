<?php

namespace Tests\Feature;

use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    public function test_asset_list_page_is_displayed(): void
    {
        Asset::factory()->create();

        $this->get(route("assets"))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component("Assets/Index")
                ->has("assets.data", 1)
            );
    }

    public function test_asset_details_page_is_displayed(): void
    {
        $asset = Asset::factory()->create();

        $this->get(route("assets.show", $asset))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component("Assets/Show")
                ->where("asset.id", $asset->id)
            );
    }

    public function test_assets_can_be_searched_by_property_number(): void
    {
        Asset::factory()->create([
            "property_number" => "NCIP-1234",
        ]);

        Asset::factory()->create([
            "property_number" => "NCIP-5678",
        ]);

        $this->get(route("assets", ["search" => "NCIP-1234"]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component("Assets/Index")
                ->has("assets.data", 1)
                ->where("assets.data.0.property_number", "NCIP-1234")
            );
    }

    public function test_assets_can_be_filtered_by_type(): void
    {
        Asset::factory()->create(["type" => "Laptop"]);
        Asset::factory()->create(["type" => "Printer"]);

        $this->get(route("assets", ["type" => "Laptop"]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component("Assets/Index")
                ->has("assets.data", 1)
                ->where("assets.data.0.type", "Laptop")
            );
    }
public function test_unverified_user_cannot_create_an_asset(): void
{
    $user = \App\Models\User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route("assets.store"), [])
        ->assertRedirect(route("verification.notice"));
}
    public function test_guest_cannot_create_an_asset(): void
    {
        $response = $this->post(route("assets.store"), []);

        $response->assertRedirect(route("login"));
    }

    public function test_employee_asset_creation_is_submitted_for_approval(): void
    {
        $user = \App\Models\User::factory()->create([
            "role" => "employee",
        ]);

        $this->actingAs($user)
            ->post(route("assets.store"), [
                "property_number" => "NCIP-TEST-1001",
                "type" => "Laptop",
                "status" => "Active",
            ])
            ->assertRedirect(route("assets"));

        $this->assertDatabaseMissing("assets", [
            "property_number" => "NCIP-TEST-1001",
        ]);

        $this->assertDatabaseHas("asset_changes", [
            "user_id" => $user->id,
            "action" => "create",
            "status" => "pending",
        ]);
    }
public function test_admin_can_create_an_asset_directly(): void
{
    $admin = \App\Models\User::factory()->create([
        "role" => "admin",
    ]);

    $this->actingAs($admin)
        ->post(route("assets.store"), [
            "property_number" => "NCIP-TEST-1002",
            "type" => "Laptop",
            "status" => "Active",
        ])
        ->assertRedirect(route("assets"));

    $this->assertDatabaseHas("assets", [
        "property_number" => "NCIP-TEST-1002",
    ]);

    $this->assertDatabaseMissing("asset_changes", [
        "action" => "create",
        "data->property_number" => "NCIP-TEST-1002",
    ]);
}
public function test_employee_asset_update_is_submitted_for_approval(): void
{
    $user = \App\Models\User::factory()->create([
        "role" => "employee",
    ]);

    $asset = Asset::factory()->create([
        "property_number" => "NCIP-TEST-1003",
        "description" => "Original description",
    ]);

    $this->actingAs($user)
        ->put(route("assets.update", $asset), [
            "property_number" => $asset->property_number,
            "type" => $asset->type,
            "status" => $asset->status,
            "description" => "Updated description",
        ])
        ->assertRedirect(route("assets.show", $asset));

    $this->assertDatabaseHas("assets", [
        "id" => $asset->id,
        "description" => "Original description",
    ]);

    $this->assertDatabaseHas("asset_changes", [
        "asset_id" => $asset->id,
        "user_id" => $user->id,
        "action" => "update",
        "status" => "pending",
    ]);
}
public function test_admin_can_update_an_asset_directly(): void
{
    $admin = \App\Models\User::factory()->create([
        "role" => "admin",
    ]);

    $asset = Asset::factory()->create([
        "description" => "Original description",
    ]);

    $this->actingAs($admin)
        ->put(route("assets.update", $asset), [
            "property_number" => $asset->property_number,
            "type" => $asset->type,
            "status" => $asset->status,
            "description" => "Updated description",
        ])
        ->assertRedirect(route("assets.show", $asset));

    $this->assertDatabaseHas("assets", [
        "id" => $asset->id,
        "description" => "Updated description",
    ]);

    $this->assertDatabaseMissing("asset_changes", [
        "asset_id" => $asset->id,
        "action" => "update",
        "status" => "pending",
    ]);
}
public function test_employee_asset_deletion_is_submitted_for_approval(): void
{
    $user = \App\Models\User::factory()->create([
        "role" => "employee",
    ]);

    $asset = Asset::factory()->create();

    $this->actingAs($user)
        ->delete(route("assets.destroy", $asset))
        ->assertRedirect(route("assets"));

    $this->assertDatabaseHas("assets", [
        "id" => $asset->id,
    ]);

    $this->assertDatabaseHas("asset_changes", [
        "asset_id" => $asset->id,
        "user_id" => $user->id,
        "action" => "delete",
        "status" => "pending",
    ]);
}
public function test_admin_can_delete_an_asset_directly(): void
{
    $admin = \App\Models\User::factory()->create([
        "role" => "admin",
    ]);

    $asset = Asset::factory()->create();

    $this->actingAs($admin)
        ->delete(route("assets.destroy", $asset))
        ->assertRedirect(route("assets"));

    $this->assertDatabaseMissing("assets", [
        "id" => $asset->id,
    ]);

    $this->assertDatabaseMissing("asset_changes", [
        "asset_id" => $asset->id,
        "action" => "delete",
        "status" => "pending",
    ]);
}
}
