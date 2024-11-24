<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaEmpresa extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'area_id'
    ];

    function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
