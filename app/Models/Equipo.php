<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Recepcion;
use App\Models\Proveedor;
use App\Models\FotoEquipo;

class Equipo extends Model
{
   use HasFactory;

    protected $fillable = [
        'nombre',
        'serie',
        'proveedores_id',
        'recepciones_id',
        'estado',
        'observaciones',
        'tipo',
        'marca',
        'modelo',
        'color',
        'voltaje',
        'cable_positivo',
        'cable_negativo',
        'rpm',
        'potencia',
        'partes_faltantes',
        'trabajo_realizar',
        'costo_estimado'
    ];

    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class, 'recepciones_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedores_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoEquipo::class, 'equipo_id');
    }
}
