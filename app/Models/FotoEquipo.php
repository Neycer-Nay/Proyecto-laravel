<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Equipo;

class FotoEquipo extends Model
{
    use HasFactory;

    protected $table = 'fotos_equipos';

    protected $fillable = [
        'equipo_id',
        'ruta',
        'descripcion'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class);
    }

    public function FotoEquipo()
    {
        return $this->belongsTo(FotoEquipo::class);
    }

    
}
