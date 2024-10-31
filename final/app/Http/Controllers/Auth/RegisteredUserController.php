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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation rules adjusted for s-number
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            's_number' => ['required', 'string', 'unique:users,s_number'], // Ensure unique s-number
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the student user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            's_number' => $request->s_number, // Save s-number
            'password' => Hash::make($request->password),
            'user_type' => 'student', // Assign user type as student
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect student users to the enrollments page
        if ($user->user_type === 'student') {
            return redirect()->route('courses.index');
        }

        // Redirect other user types (like teachers) to the dashboard
        return redirect(route('Dashboards.dashboard', absolute: false));
    }
}
