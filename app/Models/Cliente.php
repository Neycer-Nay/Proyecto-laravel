<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Recepcion;   

class Cliente extends Model
{
   use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'tipo_documento',
        'documento',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'pais'
    ];

    public function recepciones()
    {
        return $this->hasMany(Recepcion::class);
    }
}
