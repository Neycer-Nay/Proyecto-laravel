<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class Usuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $titulo = 'Administrar Usuarios';
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('modules.usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:Gerente,Contabilidad,Supervisor,Tecnico,Recepcionista',
            'activo' => 'sometimes|boolean'
        ]);

        try {
            User::create([
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'rol' => $validatedData['rol'],
                'activo' => $validatedData['activo'] ?? true
            ]);

            return redirect()->route('usuarios.index')
                   ->with('success', 'Usuario creado correctamente');

        } catch (\Exception $e) {
            return back()->withInput()
                   ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {
        try {
            // Buscar el usuario
            $user = User::findOrFail($id);
            
            // Opcional: Evitar que un usuario se elimine a sí mismo
            if (Auth::id() == $user->id) {
                return redirect()->route('usuarios.index')
                    ->with('error', 'No puedes eliminar tu propio usuario');
            }
            
            // Eliminar el usuario
            $user->delete();
            
            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado correctamente');
                
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->rol !== 'Gerente') {
                abort(403, 'No tienes permiso para acceder a esta sección.');
            }
            return $next($request);
        });
    }
}
