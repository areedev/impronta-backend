<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionTeorica extends Model
{
    use HasFactory;
    protected $table = 'evaluaciones_teoricas';

    function items()
    {
        return $this->hasMany(ItemEvaluacionTeorica::class, 'evaluacion_id', 'evaluacion_id');
    }

    public function getPorcentajeTeoricaAttribute()
    {
        return ($this->nota / 4) * 100;
    }

    public function getPorcentajeTotalAttribute()
    {
        $nota = $this->nota;
        return ($nota / 4) * 20;
    }

    function getNotaTotalAttribute(){
        $porcentaje = $this->getPorcentajeTotalAttribute();
        return $porcentaje * (4 / 100);
    }
}
