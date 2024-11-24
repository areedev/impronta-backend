<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    function empresa_antigua()
    {
        return $this->belongsTo(Empresa::class, 'empresa_antigua_id');
    }

    function empresa_nueva()
    {
        return $this->belongsTo(Empresa::class, 'empresa_nueva_id');
    }
}
