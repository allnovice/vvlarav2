<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_head_can_create_weekly_maintenance_schedule(): void
    {
        $itHead = User::factory()->create([
            "role" => "it_head",
        ]);

        $asset = Asset::factory()->create();

        $this->actingAs($itHead)
            ->post(route("maintenance-schedule.store", $asset), [
                "maintenance_date" => "2026-10-19",
                "frequency" => "Weekly",
                "notes" => "Weekly maintenance test",
            ])
            ->assertRedirect();

        $this->assertDatabaseHas("maintenance_schedules", [
            "asset_id" => $asset->id,
            "frequency" => "Weekly",
            "next_due_date" => "2026-10-26",
            "created_by" => $itHead->id,
            "notes" => "Weekly maintenance test",
        ]);
    }
}
