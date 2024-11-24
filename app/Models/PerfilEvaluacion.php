<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'perfil_evaluaciones';

    public function creador()
    {
        return $this->hasOne(Perfil::class, 'user_id', 'usuario_creador');
    }

    function secciones()
    {
        return $this->hasMany(SeccionPerfilEvaluacion::class, 'perfil_evaluacion_id')->orderBy('orden', 'asc');
    }
}
