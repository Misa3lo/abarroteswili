<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario; // Importamos el modelo Usuario

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de inicio de sesión.
     */
    // app/Http/Controllers/LoginController.php

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Usamos Auth::attempt() ya que configuramos el modelo correctamente
        if (Auth::attempt($credentials)) {

            // Regenerar la sesión es CRÍTICO para evitar fijación
            $request->session()->regenerate();

            // Forzar redirección directa, ignorando el intended()
            return redirect()->route('dashboard');
        }

        // Falla: Retornar al formulario con error
        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('usuario');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
