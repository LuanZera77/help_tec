<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChamadoController extends Controller
{
    public function index(){
        $chamados = Chamado::all();
        return view('lista_chamados', ['chamados'=> $chamados]);
    }
    public function create_chamado(Request $request){
        Chamado::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'solicitante' => $request->solicitante,
            'data_de_abertura' => now(),
            'status' => 'pendente',
        ]);
        return redirect('/');
    }
    public function delete_chamado($id){
        $user = Chamado::findOrFail($id);
        $user->delete();
        return redirect('/');
    }
}
