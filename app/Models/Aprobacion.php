<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aprobacion extends Model
{
    use HasFactory;

    protected $table = 'aprobaciones';

    function evaluacion() {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }
}
