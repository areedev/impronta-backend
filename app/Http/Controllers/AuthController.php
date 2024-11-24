<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use thiagoalessio\TesseractOCR\TesseractOCR;

class AuthController extends Controller
{
    public function index()
    {
        return view('layouts.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                ->withSuccess('Inicio de sesión éxitoso.');
        }

        return redirect("login")->withErrors(['Las credenciales no son correctas']);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

    function ocr()
    {
        $imagePath = public_path('rut.jpg');
        // Extrae el texto de la imagen
        $text = (new TesseractOCR($imagePath))
            ->lang('spa') // Establece el idioma (español)
            ->run();

        // Convierte la codificación a UTF-8
        $text = mb_convert_encoding($text, 'UTF-8', 'auto');

        // Busca el nombre en el texto
        preg_match('/\s+NOMBRES\s+([^\n]+)\s+([^\n]+)/', $text, $nombres);
        preg_match('/\s+RUN\s+([^\n]+)\s+([^\n]+)/', $text, $run);

        // Retorna el nombre
        $nombre = $nombres[1] ?? null;

        preg_match('/\s+APELLIDOS\.\s+([^\n]+)\s+([^\n]+)\s+/', $text, $apellidos);
        $apellido = $apellidos[1] ?? null;
        $apellido2 = $apellidos[2] ?? null;
        $run = $run[1] ?? null;

        print_r($text);
        echo '<br><br>';
        echo $nombre . ' ';
        echo $apellido . ' ';
        echo $apellido2 . ' ';
        echo $run . ' ';
        return;
    }
}
