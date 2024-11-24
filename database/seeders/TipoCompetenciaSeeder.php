<?php

namespace Database\Seeders;

use App\Models\TipoCompetencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoCompetenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = array(
            array("abreviatura" => "CCC", "nombre" => "Competencias Condicionantes Críticas:Vehículos Liivianos, Maquinaria Industrial, Vehículos de Transporte de Personas y Carga"),
            array("abreviatura" => "CCCF", "nombre" => "Competencias Condicionantes Críticas para Faena"),
            array("abreviatura" => "CCP", "nombre" => "Competencias Condicionantes por Perfil"),
            array("abreviatura" => "CIMP", "nombre" => "CIMP"),

        );
        foreach ($tipos as $tipo) {
            TipoCompetencia::create($tipo);
        }
    }
}
