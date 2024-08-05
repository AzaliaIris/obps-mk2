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
use Illuminate\Support\Facades\Log;

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
    /**
 * Handle an incoming registration request.
 *
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(Request $request): RedirectResponse
{
    try {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'usertype' => ['required', 'string', 'in:admin,supervisor,user'],
            'jabatan' => ['required', 'string', 'max:255'],
            //'tim' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'usertype' => $request->usertype,
            'jabatan' => $request->jabatan,
            //'tim' => $request->tim,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //Auth::login($user);

        return redirect()->route('view_monitor_user')->with('success', 'User berhasil diajukan.');
        //return redirect()->route('view_pengajuan_kegiatan_user');
    } catch (\Exception $e) {
        Log::error('Registration error: ' . $e->getMessage(), ['exception' => $e]);
        return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again later.']);
    }
}

}

