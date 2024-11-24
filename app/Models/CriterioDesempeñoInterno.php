<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterioDesempeñoInterno extends Model
{
    use HasFactory;

    function competencia() {
        return $this->belongsTo(Competencia::class, 'competencia_id');
    }
}
