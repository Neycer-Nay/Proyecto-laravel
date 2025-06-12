<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Equipo;

class FotoEquipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'ruta',
        'descripcion'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    
}
