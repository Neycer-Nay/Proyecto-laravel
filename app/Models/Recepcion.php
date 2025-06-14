<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Equipo;  

class Recepcion extends Model
{
   use HasFactory;

    protected $table = 'recepciones';

    protected $fillable = [
        'numero_recepcion',
        'fecha_recepcion',
        'hora_ingreso',
        'cliente_id',
        'users_id',
        'procedente',
        'presupuesto_inicial',
        'registro_fotografico',
        'observaciones',
        'estado',
        'fecha_limite_retiro',
        'entregado_con_boleta',
        'nombre_receptor_entrega',
        'fecha_entrega'
    ];

    protected $casts = [
        'registro_fotografico' => 'boolean',
        'entregado_con_boleta' => 'boolean',
        'fecha_recepcion' => 'date:d/m/Y',
        'fecha_limite_retiro' => 'date',
        'fecha_entrega' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function encargado()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'recepciones_id');
    }
    public function fotos()
    {
        return $this->hasMany(FotoEquipo::class);
    }
    
}
