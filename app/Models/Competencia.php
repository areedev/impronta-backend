<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    function tipo()
    {
        return $this->belongsTo(TipoCompetencia::class, 'tipo_competencia_id');
    }

    function criterios()
    {
        return $this->hasMany(CriterioDesempeñoInterno::class, 'competencia_id');
    }
}
