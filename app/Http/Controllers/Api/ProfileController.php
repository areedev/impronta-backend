<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Perfil;
use App\Models\PerfilEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Image;

class ProfileController extends BaseApiController
{
    public function index()
    {
        $usuario = User::find(Auth::id());
        $usuario->perfil = $usuario->perfil;
        $usuario->perfil->email = $usuario->email;
        return $this->sendResponse($usuario, 'Fetched data successfully');
    }
    
    public function update(Request $request)
    {
        $id = Auth::id();
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

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
            if ($old_image != 'avatar.png') {
                if (File::exists(public_path('/uploads/avatars/'.$old_image.''))) {
                    File::delete(public_path('/uploads/avatars/'.$old_image.''));
                }
            }
            Image::make($request->file('imagen'))
                ->save(public_path() . '/' . $path2);

            $perfil->avatar = $name;
        }
        $perfil->save();
        $perfil->email = $user->email;
        return $this->sendResponse($perfil, 'Perfil actualizado con éxito');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return $this->sendError("error", "La antigua contraseña no coincide.", 400);
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->sendResponse("success", "La contraseña ha sido cambiada con éxito.");
    }
}