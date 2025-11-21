<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->input('q');
        $query = User::query()->with('roles')->orderBy('created_at', 'desc');

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('backend.users.index', compact('users', 'q'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        return view('backend.users.form', [
            'user' => new User,
            'roles' => $roles,
            'mode' => 'create'
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!empty($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function show($id): View
    {
        $user = User::with('roles')->findOrFail($id);
        return view('backend.users.show', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::orderBy('name')->get();
        return view('backend.users.form', [
            'user' => $user,
            'roles' => $roles,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting primary admin (customise as needed)
        if ($user->id === 1) {
            if (request()->wantsJson() || request()->expectsJson()) {
                return response()->json(['message' => 'Cannot delete the primary admin.'], 400);
            }
            return redirect()->back()->with('error', 'Cannot delete the primary admin.');
        }

        $user->roles()->detach();
        $user->delete();

        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json(['message' => 'User deleted.']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
