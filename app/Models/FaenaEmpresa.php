<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaenaEmpresa extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'faena_id'
    ];

    function faena()
    {
        return $this->belongsTo(Faena::class, 'faena_id');
    }
}
