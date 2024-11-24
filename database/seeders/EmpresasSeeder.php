<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\AreaEmpresa;
use App\Models\Empresa;
use App\Models\Faena;
use App\Models\FaenaEmpresa;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'cponce@growth4u.cl',
            'password' => 'impronta2024*'
        ]);

        $perfil = Perfil::create([
            'user_id' => $user->id,
            'nombre' => 'Usuario',
            'apellido' => 'Growth4u',
            'telefono' => '123456789',
        ]);

        $user->assignRole([2]);

        $datos = array('user_id' => 2, 'nombre' => 'Growth4u', 'rut' => '11111111-1', 'contacto' => 'Cristopher Ponce', 'email' => 'contacto@growth4u.cl', 'telefono_contacto' => '123456789', 'direccion' => 'Santiago');

        $empresa = Empresa::create($datos);

        $faena = new Faena();
        $faena->nombre = 'Faena 1';
        $faena->save();

        $area = new Area();
        $area->nombre = 'Area 1';
        $area->save();

        $faenaempresa = new FaenaEmpresa();
        $faenaempresa->empresa_id = $empresa->id;
        $faenaempresa->faena_id = $faena->id;
        $faenaempresa->save();

        $areaempresa = new AreaEmpresa();
        $areaempresa->empresa_id = $empresa->id;
        $areaempresa->area_id = $area->id;
        $areaempresa->save();
    }
}
