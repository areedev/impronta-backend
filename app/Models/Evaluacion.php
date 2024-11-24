<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    function candidato()
    {
        return $this->hasOne(Candidato::class, 'id', 'candidato_id');
    }

    function empresa()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresa_id');
    }

    function faena()
    {
        return $this->hasOne(Faena::class, 'id', 'faena_id');
    }

    function area()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    function perfilEvaluacion()
    {
        return $this->belongsTo(PerfilEvaluacion::class, 'perfil_evaluacion_id');
    }

    public function creador()
    {
        return $this->hasOne(Perfil::class, 'user_id', 'usuario_creador');
    }

    function resultado()
    {
        return $this->hasMany(ResultadoEvaluacion::class, 'evaluacion_id');
    }

    function criterios()
    {
        return $this->hasMany(CriterioDesempeñoInternoEvaluacion::class, 'evaluacion_id');
    }

    function teorica()
    {
        return $this->hasOne(EvaluacionTeorica::class, 'evaluacion_id');
    }

    function aprobacion() {
        return $this->hasOne(Aprobacion::class, 'evaluacion_id');
    }

    function getDatosCriterioInternoAttribute()
    {

        $cantidadTotalItems = 0;
        $notas = 0;
        $porcentaje = 0;

        foreach ($this->criterios as $criterio) {
            $notatemporal = $criterio->nota;
            $notas += $notatemporal;
            $porcentajetemporal = number_format(round(($notatemporal  / 4) * 100, 2), 2);
            $porcentaje += $porcentajetemporal;
            $cantidadTotalItems++;
        }
        $datos = [
            'notas' => $notas,
            'cantidad_items' => $cantidadTotalItems,
            'porcentaje' => $porcentaje
        ];
        return $datos;
    }

    public function getNotaPracticaAttribute()
    {
        $cantidadTotalItems = $this->getDatosCriterioInternoAttribute()['cantidad_items'];
        $notas = $this->getDatosCriterioInternoAttribute()['notas'];

        foreach ($this->perfilEvaluacion->secciones as $seccion) {
            $cantidadItemsSeccion = $seccion->items->count();
            $cantidadTotalItems += $cantidadItemsSeccion;
        }

        foreach ($this->resultado as $resultado) {
            $notatemporal = $resultado->nota;
            $notas += $notatemporal;
        }

        return round(($notas / $cantidadTotalItems),2);
    }

    public function getPorcentajePracticaAttribute()
    {
        $cantidadTotalItems = $this->getDatosCriterioInternoAttribute()['cantidad_items'];
        $porcentaje = $this->getDatosCriterioInternoAttribute()['porcentaje'];

        foreach ($this->perfilEvaluacion->secciones as $seccion) {
            $cantidadItemsSeccion = $seccion->items->count();
            $cantidadTotalItems += $cantidadItemsSeccion;
        }

        foreach ($this->resultado as $resultado) {
            $porcentajetemporal = $resultado->porcentaje;
            $porcentaje += $porcentajetemporal;
        }

        return round(($porcentaje / $cantidadTotalItems),2);
    }

    public function getPorcentajeTotalAttribute()
    {
        $nota = $this->getNotaPracticaAttribute();
        return round(($nota / 4) * 80, 2);
    }

    function getNotaTotalAttribute()
    {
        $porcentaje = $this->getPorcentajeTotalAttribute();
        return round($porcentaje * (4 / 100), 2);
    }
}
