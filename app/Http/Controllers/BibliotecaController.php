<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BibliotecaController extends Controller
{
    function index() {
        return view('biblioteca.index');
    }
}
