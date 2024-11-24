<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'usuario@impronta.cl',
            'password' => 'impronta2024*'
        ]);

        $perfil = Perfil::create([
            'user_id' => $user->id,
            'nombre' => 'Usuario',
            'apellido' => 'Impronta',
            'telefono' => '123456789',
        ]);
      
        $role = Role::create(['name' => 'administrador']);
       
        $permissions = Permission::pluck('id','id')->all();
     
        $role->syncPermissions($permissions);
       
        $user->assignRole([$role->id]);

        $rolempresa = Role::create(['name' => 'empresa']);
        $rolcandidato = Role::create(['name' => 'candidato']);
        $rolevaluador = Role::create(['name' => 'evaluador']);
    }
}
