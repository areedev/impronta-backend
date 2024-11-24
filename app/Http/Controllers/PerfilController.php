<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\User;
use Auth;
use File;
use Image;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = User::find(Auth::id());
        return view('perfil.index', compact('usuario'));
    }

    public function seguridad()
    {
        return view('perfil.seguridad');
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::find($id);
        $user->email = $request->input('email');
        $user->save();

        $perfil = Perfil::find($id);

        $old_image = $perfil->avatar;
        $perfil->nombre = $request->input('nombre');
        $perfil->apellido = $request->input('apellido');
        $perfil->telefono = $request->input('telefono');
        if ($request->file('imagen')) {

            $name = '' . $id . '_' . time() . '-' . $request->file('imagen')->getClientOriginalName();
            $path2 = 'uploads/avatars/' . $name;

            if (!is_dir('' . public_path() . '/uploads/avatars/')) {
                mkdir('' . public_path() . '/uploads/avatars/', 0755, TRUE);
            }
            if($old_image != 'avatar.png'){
                if(File::exists(public_path('/uploads/avatars/'.$old_image.''))){
                    File::delete(public_path('/uploads/avatars/'.$old_image.''));
                    }
            }
            Image::make($request->file('imagen'))
                ->save(public_path() . '/' . $path2);

            $perfil->avatar = $name;
        }
        $perfil->save();

        return redirect()->route('perfil.index')
            ->with('success', 'Perfil actualizado con éxito');
    }

    public function updatePassword(Request $request)
    {
        # Validation

        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ];

        $customMessages = [
            'new_password.confirmed' => 'El campo confirmación de contraseña no coincide.'
        ];

        $this->validate($request, $rules, $customMessages);

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "La antigua contraseña no coincide.");
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "La contraseña ha sido cambiada con éxito.");
    }
}
