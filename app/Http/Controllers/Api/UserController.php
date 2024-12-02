<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Perfil;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseApiController
{
    public function index()
    {
        $empresas = Empresa::where('user_id', null)->get();
        $roles = Role::orderBy('id')->get()->all();
        $users = User::select('id', 'email')->get();
        $users->each(function($user) {
            $user->perfil;
            $user->perfil->email = $user->email;
            $user->perfil->role = $user->getRoleNames()[0];
        });
        return $this->sendResponse([
            'users' => $users,
            'empresas' => $empresas,
            'roles' => $roles
        ], 'Fetched data successfully');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password|min:8',
            'rol' => 'required|exists:roles,name',
            'empresa' => 'nullable|exists:empresas,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Email already registered', $validator->errors(), 422);
        }
        $customMessages = [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.same' => 'Los campos Contraseña y Confirmar Contraseña deben ser iguales.'
        ];

        // if($request->input('rol') == 'empresa' && $request->input('empresa')){
        // } else {
        //     return $this->sendError('Failed', 'Para crear un usuario con rol de empresa debe asignarle una empresa obligatoriamente.', 400);
        // }     
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $userid = $user->id;
        $user->assignRole($request->input('rol'));


        $perfil = new Perfil;
        $perfil->user_id = $user->id;
        $perfil->nombre = $request->nombre;
        $perfil->apellido = $request->apellido;
        $perfil->telefono = $request->telefono;
        $perfil->save();

        // $empresa->user_id = $userid;
        // $empresa->save();

        $user->perfil;
        $user->perfil->email = $user->email;
        $user->perfil->role = $user->getRoleNames()[0];
        return $this->sendResponse($user, '¡Usuario creado con éxito!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|same:confirm_password|min:8',
            'rol' => 'required|exists:roles,name',
            'empresa' => 'nullable|exists:empresas,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Email already registered', $validator->errors(), 422);
        }
        $user = User::find($id);
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = $request->password;
        }
        $user->save();
        $user->perfil;
        $user->perfil->email = $user->email;
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('rol'));
        $user->perfil->role = $user->getRoleNames()[0];

        $perfil = Perfil::where('user_id', $user->id)->first();
        $perfil->nombre = $request->nombre;
        $perfil->apellido = $request->apellido;
        $perfil->telefono = $request->telefono;
        $perfil->save();

        return $this->sendResponse($user, '¡Usuario actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id > 1) {
            User::find($id)->delete();
            return $this->sendResponse($id, 'Usuario eliminada');
        } else {
            return $this->sendError('Failed', 'No puede eliminar este usuario.', 400);
        }
    }
}