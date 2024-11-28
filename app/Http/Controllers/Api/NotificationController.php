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

class NotificationController extends BaseApiController
{
    public function index()
    {
        $usuario = User::find(Auth::id());
        $notifications = $usuario->notifications;
        return $this->sendResponse($notifications, 'Fetched data successfully');
    }
    
}