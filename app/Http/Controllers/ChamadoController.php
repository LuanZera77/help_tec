<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function index(){
        $chamados = Chamado::all();
        return view('lista_chamados', ['chamados'=> $chamados]);
    }
    public function create_chamado(Request $request){

    }
}
