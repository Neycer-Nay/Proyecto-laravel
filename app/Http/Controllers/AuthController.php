<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{    
    public function index() 
    {
        return view('modules.auth.login');
    }

    public function logear(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user=User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credencial incorrectas.'])->withInput();
        }
        if (!$user->activo) {
            return back()->withErrors(['email' => 'Usuario inactivo.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
       
    }

    public function crearAdmin()
    {
        $usuario = User::where('email', 'Admin@gmail.com')->first();

        if (!$usuario) {
            User::create([
                'nombre' => 'Neycer',
                'email' => 'Admin@gmail.com',
                'password' => Hash::make('Admin1234'),
                'activo' => true,
                'rol' => 'Gerente',
            ]);

            return "Usuario administrador creado exitosamente.";
        }

        return "El usuario administrador ya existe. No es necesario crearlo nuevamente.";
    }


    public function logout()
    {
        Auth::logout();
        

        return to_route('login');
    }
}