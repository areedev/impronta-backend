<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    public function getNombrecompletoAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellido.' ('.$this->usuario->email.')';
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function empresa() {
        return $this->belongsTo(Empresa::class, 'user_id', 'user_id');
    }
}
