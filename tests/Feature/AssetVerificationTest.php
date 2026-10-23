<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_asset_verification(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $verification = AssetVerification::create([
            'asset_id' => $asset->id,
            'user_id' => $employee->id,
            'status' => AssetVerification::STATUS_PENDING,
            'remarks' => 'Asset checked and confirmed.',
        ]);

        $this->actingAs($admin)
            ->post(route('asset-verifications.approve', $verification), [
                'reviewer_remarks' => 'Approved.',
            ])
            ->assertRedirect(route('asset-verifications.index'));

        $this->assertDatabaseHas('asset_verifications', [
            'id' => $verification->id,
            'status' => AssetVerification::STATUS_APPROVED,
            'reviewed_by' => $admin->id,
            'reviewer_remarks' => 'Approved.',
        ]);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'verified_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('asset_histories', [
            'asset_id' => $asset->id,
            'type' => 'verification',
        ]);
    }

    public function test_admin_can_reject_asset_verification(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $verification = AssetVerification::create([
            'asset_id' => $asset->id,
            'user_id' => $employee->id,
            'status' => AssetVerification::STATUS_PENDING,
        ]);

        $this->actingAs($admin)
            ->post(route('asset-verifications.reject', $verification), [
                'reviewer_remarks' => 'Please provide clearer photos.',
            ])
            ->assertRedirect(route('asset-verifications.index'));

        $this->assertDatabaseHas('asset_verifications', [
            'id' => $verification->id,
            'status' => AssetVerification::STATUS_REJECTED,
            'reviewed_by' => $admin->id,
            'reviewer_remarks' => 'Please provide clearer photos.',
        ]);
    }
public function test_user_cannot_approve_their_own_verification(): void
{
    $user = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $verification = AssetVerification::create([
        'asset_id' => $asset->id,
        'user_id' => $user->id,
        'status' => AssetVerification::STATUS_PENDING,
    ]);

    $this->actingAs($user)
        ->post(route('asset-verifications.approve', $verification))
        ->assertSessionHasErrors('verification');

    $this->assertDatabaseHas('asset_verifications', [
        'id' => $verification->id,
        'status' => AssetVerification::STATUS_PENDING,
    ]);
}
public function test_employee_cannot_approve_asset_verification(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $requester = User::factory()->create(['role' => 'employee']);
    $asset = Asset::factory()->create();

    $verification = AssetVerification::create([
        'asset_id' => $asset->id,
        'user_id' => $requester->id,
        'status' => AssetVerification::STATUS_PENDING,
    ]);

    $this->actingAs($employee)
        ->post(route('asset-verifications.approve', $verification))
        ->assertForbidden();

    $this->assertDatabaseHas('asset_verifications', [
        'id' => $verification->id,
        'status' => AssetVerification::STATUS_PENDING,
    ]);
}
public function test_employee_can_submit_asset_verification_with_photo(): void
{
    \Illuminate\Support\Facades\Storage::fake('public');

    $employee = User::factory()->create(['role' => 'employee']);
    $asset = Asset::factory()->create();

    $photo = \Illuminate\Http\UploadedFile::fake()
        ->image('verification.jpg');

    $this->actingAs($employee)
        ->post(route('asset-verifications.store', $asset), [
            'remarks' => 'Asset verified.',
            'photos' => [$photo],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('asset_verifications', [
        'asset_id' => $asset->id,
        'user_id' => $employee->id,
        'status' => \App\Models\AssetVerification::STATUS_PENDING,
        'remarks' => 'Asset verified.',
    ]);
}
public function test_employee_cannot_submit_duplicate_pending_verification(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $asset = Asset::factory()->create();

    \App\Models\AssetVerification::create([
        'asset_id' => $asset->id,
        'user_id' => $employee->id,
        'status' => \App\Models\AssetVerification::STATUS_PENDING,
    ]);

    \Illuminate\Support\Facades\Storage::fake('public');

    $photo = \Illuminate\Http\UploadedFile::fake()
        ->image('verification.jpg');

    $this->actingAs($employee)
        ->post(route('asset-verifications.store', $asset), [
            'photos' => [$photo],
        ])
        ->assertSessionHas('error', 'A verification request is already pending.');

    $this->assertDatabaseCount('asset_verifications', 1);
}
}
