<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\User;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(Disciplina $disciplina){
        return view('disciplina.index', compact('disciplina'));
    }
    public function store(Request $request, Disciplina $disciplina){
        if($disciplina->users()->where('user_id', $request->user_id)->exists()){
            return redirect()->route('disciplinas.users', $disciplina)->with('error', 'El usuario ya está agregado en la disciplina');
        }else{
            $disciplina->users()->attach($request->user_id);
            return redirect()->route('disciplinas.users', $disciplina)->with('success', 'Usuario agregado a la disciplina');
        }
    }
    public function busers(Request $request){
        $data=[];
        if($request->filled('q')){
            $data=User::select('name', 'id')
                ->where('name', 'like', '%'.$request->get('q').'%')
                ->where('estado', 1)
                ->orderBy('name')
                ->get();
        }
        return response()->json($data);
    }
}
