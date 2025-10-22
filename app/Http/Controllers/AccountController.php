<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        $type = $request->get('type', 'users'); // 'admins' or 'users'
        
        $query = User::query();
        
        // Role-based filtering
        if (auth()->user()->isSuperAdmin()) {
            // Super admin can see everyone
            if ($type === 'admins') {
                $query->whereIn('role', ['admin', 'superadmin']);
            } else {
                $query->whereIn('role', ['orangtua', 'anak']);
            }
        } elseif (auth()->user()->isAdmin()) {
            // Admin can only see orangtua and anak
            $query->whereIn('role', ['orangtua', 'anak']);
            $type = 'users'; // Force type to users for admin
        }
        
        // Apply search filter
        $query->when($search, function ($q, $search) {
            return $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        });
        
        // Apply role filter
        $query->when($role, function ($q, $role) {
            return $q->where('role', $role);
        });
        
        $accounts = $query->with('parent', 'children')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        // Get available roles based on user permissions
        $availableRoles = $this->getAvailableRoles();
        
        return view('account.index', compact('accounts', 'availableRoles', 'search', 'role', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'users');
        $availableRoles = $this->getAvailableRoles();
        
        // Get available children for orangtua role
        $availableChildren = User::where('role', 'anak')
                                ->whereNull('parent_user_username')
                                ->get();
        
        return view('account.create', compact('availableRoles', 'availableChildren', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:' . implode(',', $this->getAvailableRoles())],
        ];

        // Add conditional validation for child_username when role is orangtua
        if ($request->role === 'orangtua') {
            $rules['child_username'] = [
                'nullable',
                'string',
                'exists:users,username',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $childUser = User::where('username', $value)->first();
                        if ($childUser && $childUser->role !== 'anak') {
                            $fail('Username yang dipilih bukan seorang anak.');
                        }
                        if ($childUser && $childUser->parent_user_username) {
                            $fail('Anak ini sudah memiliki orang tua.');
                        }
                    }
                },
            ];
        }

        $validated = $request->validate($rules);

        // Create the user
        $userData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'parent_user_username' => null,
        ];

        $user = User::create($userData);

        // If role is orangtua and child_username is provided, link them
        if ($validated['role'] === 'orangtua' && !empty($validated['child_username'])) {
            $childUser = User::where('username', $validated['child_username'])->first();
            if ($childUser) {
                $childUser->update([
                    'parent_user_username' => $user->username
                ]);
            }
        }

        $type = in_array($validated['role'], ['admin', 'superadmin']) ? 'admins' : 'users';
        
        return redirect()->route('account.index', ['type' => $type])
                       ->with('success', 'Akun berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {
        $this->authorizeAccess($account);
        
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        $this->authorizeAccess($account);
        
        $availableRoles = $this->getAvailableRoles();
        
        // Get available children for orangtua role
        $availableChildren = User::where('role', 'anak')
                                ->where(function ($q) use ($account) {
                                    $q->whereNull('parent_user_username')
                                      ->orWhere('parent_user_username', $account->username);
                                })
                                ->get();
        
        return view('account.edit', compact('account', 'availableRoles', 'availableChildren'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account)
    {
        $this->authorizeAccess($account);
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($account->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($account->id)],
            'role' => ['required', 'in:' . implode(',', $this->getAvailableRoles())],
        ];

        // Add password validation if provided
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        // Add conditional validation for child_username when role is orangtua
        if ($request->role === 'orangtua') {
            $rules['child_username'] = [
                'nullable',
                'string',
                'exists:users,username',
                function ($attribute, $value, $fail) use ($account) {
                    if ($value) {
                        $childUser = User::where('username', $value)->first();
                        if ($childUser && $childUser->role !== 'anak') {
                            $fail('Username yang dipilih bukan seorang anak.');
                        }
                        if ($childUser && $childUser->parent_user_username && $childUser->parent_user_username !== $account->username) {
                            $fail('Anak ini sudah memiliki orang tua lain.');
                        }
                    }
                },
            ];
        }

        $validated = $request->validate($rules);

        // Prepare update data
        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Add password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Handle parent-child relationship changes
        $oldUsername = $account->username;
        
        $account->update($updateData);

        // Update children's parent_user_username if username changed
        if ($oldUsername !== $validated['username']) {
            User::where('parent_user_username', $oldUsername)
                ->update(['parent_user_username' => $validated['username']]);
        }

        // Handle orangtua role child linking
        if ($validated['role'] === 'orangtua') {
            // Remove old child relationship
            User::where('parent_user_username', $account->username)
                ->update(['parent_user_username' => null]);
            
            // Add new child relationship if provided
            if (!empty($validated['child_username'])) {
                $childUser = User::where('username', $validated['child_username'])->first();
                if ($childUser) {
                    $childUser->update([
                        'parent_user_username' => $account->username
                    ]);
                }
            }
        }

        $type = in_array($validated['role'], ['admin', 'superadmin']) ? 'admins' : 'users';
        
        return redirect()->route('account.index', ['type' => $type])
                       ->with('success', 'Akun berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        $this->authorizeAccess($account);
        
        // Don't allow deleting own account
        if ($account->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        
        // Remove parent relationship from children
        User::where('parent_user_username', $account->username)
            ->update(['parent_user_username' => null]);
        
        $account->delete();
        
        return redirect()->route('account.index')
                       ->with('success', 'Akun berhasil dihapus!');
    }

    /**
     * Get available roles based on current user's permissions
     */
    private function getAvailableRoles(): array
    {
        if (auth()->user()->isSuperAdmin()) {
            return ['admin', 'superadmin', 'orangtua', 'anak'];
        } elseif (auth()->user()->isAdmin()) {
            return ['orangtua', 'anak'];
        }
        
        return [];
    }

    /**
     * Check if current user can access the account
     */
    private function authorizeAccess(User $account)
    {
        if (auth()->user()->isSuperAdmin()) {
            return; // Super admin can access all accounts
        }
        
        if (auth()->user()->isAdmin()) {
            // Admin can only access orangtua and anak
            if (!in_array($account->role, ['orangtua', 'anak'])) {
                abort(403, 'Akses ditolak.');
            }
        } else {
            abort(403, 'Akses ditolak.');
        }
    }
}