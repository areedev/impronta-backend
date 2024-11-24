<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterioDesempeñoInternoEvaluacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'evaluacion_id',
        'criterio_id',
        'comentarios',
        'nota'
    ];
}
