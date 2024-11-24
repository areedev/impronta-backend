<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            'roles-ver',
            'roles-crear',
            'roles-editar',
            'roles-eliminar',
            'usuarios-ver',
            'usuarios-crear',
            'usuarios-editar',
            'usuarios-eliminar',
            'empresas-ver',
            'empresas-crear',
            'empresas-editar',
            'empresas-eliminar',
            'candidatos-ver',
            'candidatos-crear',
            'candidatos-editar',
            'candidatos-eliminar',
            'evaluaciones-ver',
            'evaluaciones-crear',
            'evaluaciones-editar',
            'evaluaciones-eliminar',
            'perfiles-ver',
            'perfiles-crear',
            'perfiles-editar',
            'perfiles-eliminar',
            'biblioteca-ver',
            'biblioteca-crear',
            'biblioteca-editar',
            'biblioteca-eliminar',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
