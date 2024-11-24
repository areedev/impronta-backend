<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionPerfilEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'seccion_perfil_evaluaciones';

    protected $fillable = [
        'perfil_evaluacion_id',
        'nombre',
        'orden'
    ];

    function items()
    {
        return $this->hasMany(ItemSeccionPerfilEvaluacion::class, 'seccion_id');
    }
}
