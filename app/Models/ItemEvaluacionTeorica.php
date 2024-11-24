<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemEvaluacionTeorica extends Model
{
    use HasFactory;
    protected $table = 'items_evaluaciones_teoricas';
    protected $fillable = [
        'evaluacion_id',
        'competencia_id',
        'pregunta',
        'comentario',
    ];

    function competencia()
    {
        return $this->belongsTo(Competencia::class, 'competencia_id');
    }
}
