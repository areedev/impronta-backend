<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'nombre',
        'rut',
        'contacto',
        'email',
        'telefono_contacto',
        'direccion',
        'logo'
    ];

    function faenas()
    {
        return $this->hasMany(FaenaEmpresa::class, 'empresa_id');
    }

    function areas()
    {
        return $this->hasMany(AreaEmpresa::class, 'empresa_id');
    }
}
