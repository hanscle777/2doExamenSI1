<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $user = User::where('correo', $request->correo)->first();

        if ($user && Hash::check($request->contrasena, $user->contrasena)) {
            if ($user->estado !== 'activo') {
                return back()->withErrors(['correo' => 'Tu cuenta está inactiva.']);
            }

            // Simple session-based authentication (without Laravel's default auth)
            Session::put('user_id', $user->id_usuario);
            Session::put('user_name', $user->nombre . ' ' . $user->apellido);
            Session::put('user_role', $user->id_rol);
            Session::put('authenticated', true);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['correo' => 'Las credenciales proporcionadas no son correctas.']);
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $userId = Session::get('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        if (!Hash::check($request->current_password, $user->contrasena)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->contrasena = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Contraseña cambiada exitosamente.');
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        $userId = Session::get('user_id');
        $user = User::find($userId);
        
        return view('dashboard', compact('user'));
    }
}

