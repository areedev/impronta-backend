<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPerfilEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'item_perfil_evaluaciones';

    public function creador()
    {
        return $this->hasOne(Perfil::class, 'user_id', 'usuario_creador');
    }
}
