<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{

    function index() {
        return view('notificaciones.index');
    }

    function ajustes()
    {
        $data['usuarios'] = User::pluck('email', 'id');
        $data['activos'] = User::where('notificaciones', true)->pluck('id');
        return view('notificaciones.ajustes', $data);
    }

    function actualizar(Request $request)
    {
        $this->validate($request, [
            'usuarios' => 'required',
        ]);

        $usuariosactivos = User::where('notificaciones', true)->get();
        $activosIds = $usuariosactivos->pluck('id')->toArray();

        $nuevosIds = $request->usuarios;        
        
        $aDesactivar = collect($activosIds)->diff($nuevosIds);
        $aActivar = collect($nuevosIds)->diff($activosIds);

        DB::transaction(function () use ($aDesactivar, $aActivar) {
            User::whereIn('id', $aDesactivar)->update(['notificaciones' => false]);
            User::whereIn('id', $aActivar)->update(['notificaciones' => true]);
        });

        return back()->with('success',  'Notificaciones modificadas');
    }

    function leer() {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
