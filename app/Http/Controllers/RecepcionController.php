<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Recepcion;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Equipo;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RecepcionController extends Controller
{
    public function index()
    {
        $titulo = 'Administrar Recepciones';
        $recepciones = Recepcion::with(['cliente', 'encargado'])->latest()->paginate(10);
        return view('modules.recepcion.index', compact('titulo', 'recepciones'));

    }

    public function create()
    {
        $clientes = Cliente::all();
        $usuarios = User::where('activo', true)->get();
        return view('modules.recepcion.create', compact('clientes', 'usuarios'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Validación de datos
            $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'numero_recepcion' => 'required|unique:recepciones',
                'fecha_recepcion' => 'required|date',
                'hora_ingreso' => 'required',
                'encargado_id' => 'required|exists:users,id',
                
                // Validación para equipos
                'equipos' => 'required|array|min:1',
                'equipos.*.nombre' => 'required|string|max:255',
                'equipos.*.tipo' => 'required|in:MOTOR_ELECTRICO,MAQUINA_SOLDADORA,GENERADOR_DINAMO,OTROS',
                'equipos.*.marca' => 'nullable|string|max:50',
                'equipos.*.modelo' => 'nullable|string|max:50',
                'equipos.*.estado' => 'nullable|string|max:100',
                'equipos.*.costo_estimado' => 'nullable|numeric',
                

                'equipos.*.fotos.*' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048' // 2MB
                ],
                
            ], [
                'equipos.*.nombre.required' => 'El campo nombre es requerido para todos los equipos',
                'equipos.*.tipo.required' => 'El campo tipo es requerido para todos los equipos',
                'equipos.*.tipo.in' => 'El tipo de equipo seleccionado no es válido',
                'equipos.required' => 'Debe agregar al menos un equipo',
                'equipos.min' => 'Debe agregar al menos un equipo'
            ]);
            // Crear la recepción
            $recepcion = Recepcion::create([
                'numero_recepcion' => $validated['numero_recepcion'],
                'fecha_recepcion' => $validated['fecha_recepcion'],
                'hora_ingreso' => $validated['hora_ingreso'],
                'cliente_id' => $validated['cliente_id'],
                'users_id' => $validated['encargado_id'],
                'procedente' => $validated['procedente'] ?? null,
                'presupuesto_inicial' => $validated['presupuesto_inicial'] ?? null,
                'registro_fotografico' => $request->has('registro_fotografico'),
                'observaciones' => $validated['observaciones'] ?? null,
                'estado' => 'recibido'
            ]);

            // Procesar cada equipo
            foreach ($request->equipos as $index => $equipoData) {
                $equipo = $recepcion->equipos()->create([
                    'nombre' => $equipoData['nombre'],
                    'serie' => $equipoData['serie'] ?? null,
                    'tipo' => $equipoData['tipo'],
                    'marca' => $equipoData['marca'] ?? null,
                    'modelo' => $equipoData['modelo'] ?? null,
                    'color' => $equipoData['color'] ?? null,
                    'voltaje' => $equipoData['voltaje'] ?? null,
                    'rpm' => $equipoData['rpm'] ?? null,
                    'potencia' => $equipoData['potencia'] ?? null,
                    'estado' => $equipoData['estado'] ?? null,
                    'partes_faltantes' => $equipoData['partes_faltantes'] ?? null,
                    'trabajo_realizar' => $equipoData['trabajo_realizar'] ?? null,
                    'observaciones' => $equipoData['observaciones'] ?? null,
                    'costo_estimado' => $equipoData['costo_estimado'] ?? null
                ]);

                // Guardar fotos si existen
                $fotos = $request->file("equipos.$index.fotos") ?? [];

                foreach ($fotos as $foto) {
                    if ($foto && $foto->isValid()) {
                        $path = $foto->store('public/equipos');
                        $equipo->fotos()->create([
                            'ruta' => Storage::url($path),
                            'descripcion' => 'Foto del equipo ' . $equipoData['nombre']
                        ]);
                    }
                }

            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Recepción registrada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la recepción: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'encargado', 'equipos.fotos']);
        return view('modules.recepcion.show', compact('recepcion'));
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
