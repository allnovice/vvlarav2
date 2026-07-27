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

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'department' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
        'contact_no' => ['nullable', 'string', 'max:255'],
        'role' => ['required', 'string'],
        'is_active' => ['required', 'boolean'],
    ]);

    $user->update($validated);

    return redirect()
        ->route('users.show', $user)
        ->with('success', 'User updated successfully.');
}
public function destroy(User $user)
{
    $user->delete();

    return redirect()
        ->route('users.index')
        ->with('success', 'User deleted successfully.');
}


}
