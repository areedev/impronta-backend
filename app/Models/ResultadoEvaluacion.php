<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'resultado_evaluaciones';
    protected $fillable = [
        'evaluacion_id',
        'item_id',
        'nota',
        'porcentaje',
        'comentario'
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function itemPerfilEvaluacion()
    {
        return $this->belongsTo(ItemPerfilEvaluacion::class, 'item_id');
    }

    function item() {
        return $this->belongsTo(ItemSeccionPerfilEvaluacion::class, 'item_id'); 
    }
}
