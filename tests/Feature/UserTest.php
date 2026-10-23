<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_user_can_view_users_list(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertOk();
    }

    public function test_verified_user_can_view_user_details(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.show', $target))
            ->assertOk();
    }
public function test_guest_cannot_view_users_pages(): void
{
    $target = User::factory()->create();

    $this->get(route('users.index'))
        ->assertRedirect(route('login'));

    $this->get(route('users.show', $target))
        ->assertRedirect(route('login'));
}
public function test_it_head_can_access_user_edit_page(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create();

    $this->actingAs($itHead)
        ->get(route('users.edit', $target))
        ->assertOk();
}
public function test_employee_cannot_access_user_edit_page(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $target = User::factory()->create();

    $this->actingAs($employee)
        ->get(route('users.edit', $target))
        ->assertForbidden();
}
public function test_it_head_can_update_user(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create();

    $this->actingAs($itHead)
        ->patch(route('users.update', $target), [
            'name' => 'Updated Name',
            'department' => 'IT',
            'position' => 'Technician',
            'contact_no' => '09171234567',
            'role' => 'employee',
            'is_active' => true,
        ])
        ->assertRedirect(route('users.show', $target));

    $this->assertDatabaseHas('users', [
        'id' => $target->id,
        'name' => 'Updated Name',
        'department' => 'IT',
    ]);
}
public function test_employee_cannot_update_user(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $target = User::factory()->create();

    $this->actingAs($employee)
        ->patch(route('users.update', $target), [
            'name' => 'Unauthorized Change',
            'department' => 'IT',
            'position' => 'Technician',
            'contact_no' => null,
            'role' => 'admin',
            'is_active' => true,
        ])
        ->assertForbidden();

    $this->assertDatabaseMissing('users', [
        'id' => $target->id,
        'name' => 'Unauthorized Change',
    ]);
}
public function test_it_head_can_delete_user(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create();

    $this->actingAs($itHead)
        ->delete(route('users.destroy', $target))
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseMissing('users', [
        'id' => $target->id,
    ]);
}
public function test_employee_cannot_delete_user(): void
{
    $employee = User::factory()->create(['role' => 'employee']);
    $target = User::factory()->create();

    $this->actingAs($employee)
        ->delete(route('users.destroy', $target))
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $target->id,
    ]);
}
public function test_user_update_requires_required_fields(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create();

    $this->actingAs($itHead)
        ->patch(route('users.update', $target), [])
        ->assertSessionHasErrors([
            'name',
            'department',
            'position',
            'role',
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $target->id,
        'name' => $target->name,
    ]);
}
public function test_it_head_cannot_deactivate_own_account(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);

    $this->actingAs($itHead)
        ->patch(route('users.update', $itHead), [
            'name' => $itHead->name,
            'department' => $itHead->department ?? 'IT',
            'position' => $itHead->position ?? 'Head',
            'contact_no' => $itHead->contact_no,
            'role' => $itHead->role,
            'is_active' => false,
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $itHead->id,
        'is_active' => true,
    ]);
}
public function test_user_role_rejects_arbitrary_string(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create(['role' => 'employee']);

    $this->actingAs($itHead)
        ->patch(route('users.update', $target), [
            'name' => $target->name,
            'department' => $target->department ?? 'IT',
            'position' => $target->position ?? 'Staff',
            'contact_no' => $target->contact_no,
            'role' => 'not_a_real_role',
            'is_active' => true,
        ])
        ->assertSessionHasErrors(['role']);

    $this->assertDatabaseHas('users', [
        'id' => $target->id,
        'role' => 'employee',
    ]);
}
public function test_it_head_cannot_promote_self_to_admin(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);

    $this->actingAs($itHead)
        ->patch(route('users.update', $itHead), [
            'name' => $itHead->name,
            'department' => $itHead->department ?? 'IT',
            'position' => $itHead->position ?? 'Head',
            'contact_no' => $itHead->contact_no,
            'role' => 'admin',
            'is_active' => true,
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $itHead->id,
        'role' => 'it_head',
    ]);
}
public function test_it_head_cannot_assign_admin_role_to_another_user(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $target = User::factory()->create(['role' => 'employee']);

    $this->actingAs($itHead)
        ->patch(route('users.update', $target), [
            'name' => $target->name,
            'department' => $target->department ?? 'IT',
            'position' => $target->position ?? 'Staff',
            'contact_no' => $target->contact_no,
            'role' => 'admin',
            'is_active' => true,
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $target->id,
        'role' => 'employee',
    ]);
}

public function test_it_head_cannot_modify_admin_account(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($itHead)
        ->patch(route('users.update', $admin), [
            'name' => 'Changed Admin',
            'department' => $admin->department ?? 'IT',
            'position' => $admin->position ?? 'Admin',
            'contact_no' => $admin->contact_no,
            'role' => 'employee',
            'is_active' => true,
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'role' => 'admin',
        'name' => $admin->name,
    ]);
}

public function test_it_head_cannot_delete_admin_account(): void
{
    $itHead = User::factory()->create(['role' => 'it_head']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($itHead)
        ->delete(route('users.destroy', $admin))
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
    ]);
}
}
