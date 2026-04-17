<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Chamado::query();
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $chamados = $query->orderBy('created_at', 'desc')->get();
        return view('lista_chamados', ['chamados' => $chamados]);
    }
    public function create_chamado(Request $request)
    {
        Chamado::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'solicitante' => $request->solicitante,
            'data_de_abertura' => now(),
            'status' => 'pendente',
        ]);
        return redirect('/');
    }
    public function update_status(Request $request, $id)
    {
        $chamado = Chamado::findOrFail($id);
        $chamado->status = $request->status;
        if ($request->status === 'finalizado') {
            $chamado->data_de_fechamento = now();
        } else {
            $chamado->data_de_fechamento = null;
        }
        $chamado->save();
        return redirect()->back();
    }
    public function delete_chamado($id)
    {
        $user = Chamado::findOrFail($id);
        $user->delete();
        return redirect('/');
    }
}
