<?php

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

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role'       => ['required', 'in:customer,staff,admin'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
            'base_email' => ['required', 'string', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'address'    => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'confirmed', Rules\Password::min(6)],
        ]);

        $role = $request->role;

        $emailParts = explode('@', $request->base_email);
        $email = $emailParts[0] . '.' . $role . '@' . $emailParts[1];

        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['base_email' => 'An account with this email and role already exists.'])->withInput();
        }

        $approved = $role === 'customer';

        $user = User::create([
            'name'     => trim($request->first_name . ' ' . $request->last_name),
            'username' => $request->username,
            'email'    => $email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
            'role'     => $role,
            'approved' => $approved,
        ]);

        event(new Registered($user));

        if (!$approved) {
            return redirect()->route('login')->with('status', 'Your account is pending approval. You will be notified once approved.');
        }

        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }
}
