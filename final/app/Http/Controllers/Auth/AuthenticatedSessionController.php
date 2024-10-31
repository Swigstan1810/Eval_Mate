<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to log the user in using their s-number
        if (Auth::attempt(['s_number' => $request->s_number, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Check if the authenticated user is a student
            if (Auth::user()->user_type === 'student') {
                // Redirect to the enrollments page
                return redirect()->intended(route('courses.index', absolute: false));
            }

            // Redirect teachers or other users to the dashboard
            return redirect()->intended(route('Dashboards.dashboard', absolute: false));
        }

        // If authentication fails
        return back()->withErrors([
            's_number' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
