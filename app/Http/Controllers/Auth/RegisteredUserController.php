<?php
// filepath: /Users/agusbudianto2/Downloads/Me Project/sina/app/Http/Controllers/Auth/RegisteredUserController.php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Rules\ValidChildUsername;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:anak,orangtua'],
        ];

        // Add conditional validation for child_username when role is orangtua
        if ($request->role === 'orangtua') {
            $rules['child_username'] = [
                'required',
                'string',
                'exists:users,username',
                function ($attribute, $value, $fail) {
                    // Check if the child user exists and has role 'anak'
                    $childUser = User::where('username', $value)->first();
                    if ($childUser && $childUser->role !== 'anak') {
                        $fail('Username yang dipilih bukan seorang anak.');
                    }
                    // Check if child already has a parent
                    if ($childUser && $childUser->parent_user_username) {
                        $fail('Anak ini sudah memiliki orang tua.');
                    }
                },
            ];
        }

        $validatedData = $request->validate($rules);
        if ($request->role === 'orangtua') {
            $rules['child_username'] = [
                'required',
                'string',
                new ValidChildUsername,
            ];
        }
        // Create the user
        $userData = [
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'parent_user_username' => null,
        ];

        $user = User::create($userData);

        // If role is orangtua, update the child's parent_user_username
        if ($validatedData['role'] === 'orangtua' && isset($validatedData['child_username'])) {
            $childUser = User::where('username', $validatedData['child_username'])->first();
            if ($childUser) {
                $childUser->update([
                    'parent_user_username' => $user->username
                ]);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}