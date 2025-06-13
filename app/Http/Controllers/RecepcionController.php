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
                
                // Fotos subidas tradicionalmente
                'equipos.*.fotos.*' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:10240' // 10MB
                ],
                
                // Fotos capturadas desde cámara (como base64)
                'equipos.*.captured_photos' => 'nullable|string',
                'equipos.*.captured_photos.*' => 'nullable|string',
                
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

                // Procesar fotos subidas tradicionalmente
                $fotos = $request->file("equipos.$index.fotos") ?? [];
                foreach ($fotos as $foto) {
                    if ($foto && $foto->isValid()) {
                        $this->guardarFoto($equipo, $foto);
                    }
                }

                // Procesar fotos capturadas desde cámara (base64)
                if (!empty($equipoData['captured_photos'])) {
                    $fotosCapturadas = is_array($equipoData['captured_photos']) 
                        ? $equipoData['captured_photos'] 
                        : json_decode($equipoData['captured_photos'], true);
                    
                    if (is_array($fotosCapturadas)) {
                        foreach ($fotosCapturadas as $fotoBase64) {
                            $this->guardarFotoBase64($equipo, $fotoBase64);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('recepciones.index')
                         ->with('toastr', [
                             'type' => 'success', 
                             'message' => 'Recepción creada exitosamente',
                             'title' => 'Éxito'
                         ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                         ->withInput()
                         ->with('toastr', [
                             'type' => 'error',
                             'message' => 'Error al crear recepción: ' . $e->getMessage(),
                             'title' => 'Error'
                         ]);
        }
    }

    /**
     * Guarda una foto subida tradicionalmente (archivo)
     */
    protected function guardarFoto(Equipo $equipo, $foto)
    {
        $path = $foto->store('public/equipos');
        $equipo->fotos()->create([
            'ruta' => Storage::url($path),
            'descripcion' => 'Foto del equipo ' . $equipo->nombre,
            'tipo' => 'uploaded'
        ]);
    }

    /**
     * Guarda una foto capturada desde cámara (base64)
     */
    protected function guardarFotoBase64(Equipo $equipo, $base64Image)
    {
        // Extraer la parte base64 de la cadena
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Formato de imagen no válido');
            }

            $imageData = base64_decode($imageData);
            
            if ($imageData === false) {
                throw new \Exception('Error al decodificar la imagen base64');
            }
        } else {
            throw new \Exception('Formato de datos de imagen no válido');
        }

        // Generar nombre único para el archivo
        $filename = 'equipos/' . Str::uuid() . '.' . $type;
        $storagePath = 'public/' . $filename;

        // Guardar en storage
        Storage::put($storagePath, $imageData);

        // Guardar en base de datos
        $equipo->fotos()->create([
            'ruta' => Storage::url($storagePath),
            'descripcion' => 'Foto del equipo ' . $equipo->nombre,
            'tipo' => 'captured'
        ]);
    }

    public function show(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'encargado', 'equipos.fotos']);
        return view('modules.recepcion.show', compact('recepcion'));
    }

    public function generarPDF(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'encargado', 'equipos.fotos']);

        $pdf = Pdf::loadView('modules.recepcion.pdf', compact('recepcion'));
        return $pdf->download('recepcion_'.$recepcion->numero_recepcion.'.pdf');
    }
}