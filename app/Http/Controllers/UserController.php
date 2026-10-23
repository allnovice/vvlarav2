<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {

$users = User::select([
    'id',
    'name',
    'email',
    'department',
    'position',
    'role',
    'is_active',
])
->orderBy('name')
->paginate(10);


        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }


public function show(User $user)
{
    return Inertia::render('Users/Show', [
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'department' => $user->department,
            'position' => $user->position,
            'contact_no' => $user->contact_no,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ],
    ]);
}

public function edit(User $user)
{

    return Inertia::render('Users/Edit', [
        'user' => $user,
    ]);
}
public function update(Request $request, User $user)
{
    $actor = $request->user();
    $isSelf = $actor->is($user);

    // Only Admin may modify an Admin account.
    if ($user->isAdmin() && ! $actor->isAdmin()) {
        abort(403, 'Only an Admin can modify an Admin account.');
    }

    // Prevent changing your own role or account status.
    if ($isSelf && (
        ($request->has('role') && $request->input('role') !== $user->role)
        || ($request->has('is_active')
            && (bool) $request->boolean('is_active') !== (bool) $user->is_active)
    )) {
        abort(403, 'You cannot change your own role or status.');
    }

    // Only Admin may change the status of an existing IT Head.
    if ($request->has('is_active')
        && (bool) $request->boolean('is_active') !== (bool) $user->is_active
        && ! ($actor->isAdmin() && ! $isSelf)
    ) {
        abort(403, 'You are not allowed to change this account status.');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'department' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
        'contact_no' => ['nullable', 'string', 'max:255'],
        'role' => [
            'required',
            'in:admin,it_head,property_supply_officer,technician,employee',
        ],
        'is_active' => ['sometimes', 'boolean'],
    ]);
// Only Admin may assign the Admin role.
if ($validated['role'] === 'admin' && ! $actor->isAdmin()) {
    abort(403, 'Only an Admin can assign the Admin role.');
}
    $user->update($validated);

    return redirect()
        ->route('users.show', $user)
        ->with('success', 'User updated successfully.');
}
public function destroy(Request $request, User $user)
{
    $actor = $request->user();

    // Prevent deleting your own account.
    if ($actor->is($user)) {
        abort(403, 'You cannot delete your own account.');
    }

    // Only Admin may delete an Admin account.
    if ($user->isAdmin() && ! $actor->isAdmin()) {
        abort(403, 'Only an Admin can delete an Admin account.');
    }

    $user->delete();

    return redirect()
        ->route('users.index')
        ->with('success', 'User deleted successfully.');
}

}
