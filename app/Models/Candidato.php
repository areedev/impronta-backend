<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    function bitacora()
    {
        return $this->hasMany(Bitacora::class, 'candidato_id');
    }

    function evaluaciones() {
        return $this->hasMany(Evaluacion::class, 'candidato_id');
    }
}
