<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSeccionPerfilEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'item_seccion_perfil_evaluaciones';

    protected $fillable = [
        'seccion_id',
        'item_id',
        'descripcion'
    ];

    function seccion()
    {
        return $this->belongsTo(SeccionPerfilEvaluacion::class, 'seccion_id');
    }

    function item(){
        return $this->belongsTo(ItemPerfilEvaluacion::class, 'item_id');
    }

    function competencia(){
        return $this->belongsTo(Competencia::class, 'competencia_id');
    }
}
