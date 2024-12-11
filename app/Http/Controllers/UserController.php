<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
use Spatie\Permission\Models\Role;
use DB;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        $empresas = Empresa::where('user_id', null)->pluck('nombre','id');
        $roles = Role::orderBy('id')->pluck('name', 'name')->all();
        return $dataTable->render('usuarios.index', compact('empresas','roles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password|min:8',
            'rol' => 'required|exists:roles,name',
            'empresa' => 'nullable|exists:empresas,id'
        ];

        $customMessages = [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.same' => 'Los campos Contraseña y Confirmar Contraseña deben ser iguales.'
        ];

        $this->validate($request, $rules, $customMessages);

        if($request->input('rol') == 'empresa' && $request->input('empresa')){
        } else {
            return back()->withErrors(['Para crear un usuario con rol de empresa debe asignarle una empresa obligatoriamente.']);
        }        

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

        $empresa = Empresa::find($request->empresa);
        $empresa->user_id = $userid;
        $empresa->save();

        return redirect()->route('usuarios.index')
            ->with('success', '¡Usuario creado con éxito!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('id')->pluck('name', 'name')->all();
        $view =  view('usuarios.editar', compact('user', 'roles'));
        return ['html' => $view->render()];
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password|min:6',
            'rol' => 'required'
        ];

        $customMessages = [
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.same' => 'Los campos Contraseña y Confirmar Contraseña deben ser iguales.',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find($id);
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = $request->password;
        }
        $user->save();
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('rol'));

        $perfil = Perfil::where('user_id', $user->id)->first();
        $perfil->nombre = $request->nombre;
        $perfil->apellido = $request->apellido;
        $perfil->telefono = $request->telefono;
        $perfil->save();

        return redirect()->route('usuarios.index')
            ->with('success', '¡Usuario actualizado con éxito!');
    }

    public function destroy($id)
    {
        if ($id > 1) {
            User::find($id)->delete();
            return redirect()->route('usuarios.index')->with('success', '¡User eliminado con éxito!');
        } else {
            return back()->withErrors(['msg' => 'No puede eliminar este usuario.']);
        }
    }
}
