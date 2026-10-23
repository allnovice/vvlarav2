<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetPhoto;
use App\Models\AssetPhotoChange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetPhotoChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_photo_caption_edit(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $photo = AssetPhoto::create([
            'asset_id' => $asset->id,
            'photo_path' => 'assets/photo.jpg',
            'photo_thumb_path' => 'assets/thumb.jpg',
            'caption' => 'Old caption',
            'sort_order' => 0,
        ]);

        $change = AssetPhotoChange::create([
            'asset_id' => $asset->id,
            'submitted_by' => $employee->id,
            'action' => AssetPhotoChange::ACTION_EDIT,
            'photo_path' => 'assets/photo.jpg',
            'asset_photo_id' => $photo->id,
            'caption' => 'Updated caption',
            'status' => AssetPhotoChange::STATUS_PENDING,
        ]);

        $this->actingAs($admin)
            ->post(route('asset-photo-changes.approve', $change))
            ->assertRedirect(route('asset-photo-changes.index'));

        $this->assertDatabaseHas('asset_photos', [
            'id' => $photo->id,
            'caption' => 'Updated caption',
        ]);

        $this->assertDatabaseHas('asset_photo_changes', [
            'id' => $change->id,
            'status' => AssetPhotoChange::STATUS_APPROVED,
            'reviewed_by' => $admin->id,
        ]);
    }

    public function test_admin_can_reject_photo_caption_edit(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::factory()->create();

        $photo = AssetPhoto::create([
            'asset_id' => $asset->id,
            'photo_path' => 'assets/photo.jpg',
            'photo_thumb_path' => 'assets/thumb.jpg',
            'caption' => 'Original caption',
            'sort_order' => 0,
        ]);

        $change = AssetPhotoChange::create([
            'asset_id' => $asset->id,
            'submitted_by' => $employee->id,
            'action' => AssetPhotoChange::ACTION_EDIT,
            'photo_path' => 'assets/photo.jpg',
            'asset_photo_id' => $photo->id,
            'caption' => 'Rejected caption',
            'status' => AssetPhotoChange::STATUS_PENDING,
        ]);

        $this->actingAs($admin)
            ->post(route('asset-photo-changes.reject', $change))
            ->assertRedirect(route('asset-photo-changes.index'));

        $this->assertDatabaseHas('asset_photos', [
            'id' => $photo->id,
            'caption' => 'Original caption',
        ]);

        $this->assertDatabaseHas('asset_photo_changes', [
            'id' => $change->id,
            'status' => AssetPhotoChange::STATUS_REJECTED,
            'reviewed_by' => $admin->id,
        ]);
    }
public function test_user_cannot_approve_their_own_photo_change(): void
{
    $user = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $change = AssetPhotoChange::create([
        'asset_id' => $asset->id,
        'submitted_by' => $user->id,
        'action' => AssetPhotoChange::ACTION_EDIT,
        'photo_path' => 'assets/photo.jpg',
        'asset_photo_id' => null,
        'caption' => 'My caption',
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);

    $this->actingAs($user)
        ->post(route('asset-photo-changes.approve', $change))
        ->assertSessionHasErrors('change');

    $this->assertDatabaseHas('asset_photo_changes', [
        'id' => $change->id,
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);
}
public function test_employee_cannot_approve_photo_change(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $requester = User::factory()->create(['role' => 'employee']);
    $asset = Asset::factory()->create();

    $change = AssetPhotoChange::create([
        'asset_id' => $asset->id,
        'submitted_by' => $requester->id,
        'action' => AssetPhotoChange::ACTION_EDIT,
        'photo_path' => 'assets/photo.jpg',
        'caption' => 'Updated caption',
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);

    $this->actingAs($employee)
        ->post(route('asset-photo-changes.approve', $change))
        ->assertForbidden();

    $this->assertDatabaseHas('asset_photo_changes', [
        'id' => $change->id,
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);
}
public function test_admin_can_approve_photo_deletion(): void
{
    \Illuminate\Support\Facades\Storage::fake('public');

    $employee = User::factory()->create(['role' => 'employee']);
    $admin = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $photo = AssetPhoto::create([
        'asset_id' => $asset->id,
        'photo_path' => 'assets/photo.jpg',
        'photo_thumb_path' => 'assets/thumb.jpg',
        'caption' => 'Photo to delete',
        'sort_order' => 0,
    ]);

    $change = AssetPhotoChange::create([
        'asset_id' => $asset->id,
        'submitted_by' => $employee->id,
        'action' => AssetPhotoChange::ACTION_DELETE,
        'photo_path' => 'assets/photo.jpg',
        'asset_photo_id' => $photo->id,
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);

    $this->actingAs($admin)
        ->post(route('asset-photo-changes.approve', $change))
        ->assertRedirect(route('asset-photo-changes.index'));

    $this->assertDatabaseMissing('asset_photos', [
        'id' => $photo->id,
    ]);

    $this->assertDatabaseHas('asset_photo_changes', [
        'id' => $change->id,
        'status' => AssetPhotoChange::STATUS_APPROVED,
    ]);
}
public function test_processed_photo_change_cannot_be_approved_again(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $admin = User::factory()->create(['role' => 'admin']);
    $asset = Asset::factory()->create();

    $photo = AssetPhoto::create([
        'asset_id' => $asset->id,
        'photo_path' => 'assets/photo.jpg',
        'caption' => 'Original caption',
        'sort_order' => 0,
    ]);

    $change = AssetPhotoChange::create([
        'asset_id' => $asset->id,
        'submitted_by' => $employee->id,
        'action' => AssetPhotoChange::ACTION_EDIT,
        'photo_path' => 'assets/photo.jpg',
        'asset_photo_id' => $photo->id,
        'caption' => 'Updated caption',
        'status' => AssetPhotoChange::STATUS_APPROVED,
        'reviewed_by' => $admin->id,
        'reviewed_at' => now(),
    ]);

    $this->actingAs($admin)
        ->post(route('asset-photo-changes.approve', $change))
        ->assertRedirect(route('asset-photo-changes.index'))
        ->assertSessionHas('error', 'This request has already been processed.');

    $this->assertDatabaseHas('asset_photos', [
        'id' => $photo->id,
        'caption' => 'Original caption',
    ]);
}
}
