<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return view('modules.clientes.index');
        $clientes = Cliente::latest()->paginate(10);
        return view('modules.recepcion.create', compact('clientes'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Empresa,Persona',
            'tipo_documento' => 'required|in:CI,NIT,Pasaporte,Otro',
            'documento' => 'required|string|max:50',
            'telefono' => 'required|string|max:50',
            'email' => 'nullable|email',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100'
        ]);

        $cliente = Cliente::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado exitosamente',
            'cliente' => $cliente
        ]);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
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
    public function destroy(string $id)
    {
        //
    }
}
