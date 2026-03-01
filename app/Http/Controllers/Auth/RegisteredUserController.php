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
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        //dd(session()->all());
        $email = session('invitation_email');
        return view('auth.register', compact('email'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $invitationEmail = session('invitation_email');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($invitationEmail && $request->email !== $invitationEmail) {
            abort(403, 'Email invalide pour cette invitation.');
        }

        if(User::count() == 0){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'admin',
                'password' => Hash::make($request->password),
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if (session()->has('invitation_token')) {
            $token = session()->pull('invitation_token');
            session()->forget('invitation_email');
            return redirect()->route('invitation.response', $token);
        }

        return redirect(route('colocations.index', absolute: false));
    }
}
