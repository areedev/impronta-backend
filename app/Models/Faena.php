<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faena extends Model
{
    use HasFactory;

    public function creador()
    {
        return $this->hasOne(Perfil::class, 'user_id', 'usuario_creador');
    }
}
