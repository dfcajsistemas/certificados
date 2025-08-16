<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Proyecto $proyecto){
        return view('proyecto.index', compact('proyecto'));
    }

    public function store(Request $request, Proyecto $proyecto){
        if($proyecto->empresas()->where('empresa_id', $request->empresa_id)->exists()){
            return redirect()->route('proyectos.empresas', $proyecto)->with('error', 'La empresa ya está agregada al proyecto');
        }else{
            $proyecto->empresas()->attach($request->empresa_id);
            return redirect()->route('proyectos.empresas', $proyecto)->with('success', 'Empresa agregada al proyecto');
        }
    }

    public function bempresas(Request $request){
        $data=[];
        if($request->filled('q')){
            $data=Empresa::select('razon_social', 'id')
                ->where('razon_social', 'like', '%'.$request->get('q').'%')
                ->where('estado', 1)
                ->orderBy('razon_social')
                ->get();
        }
        return response()->json($data);
    }
}
