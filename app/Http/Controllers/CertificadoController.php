<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Certificado;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function certificados(Capacitacion $capacitacion){
        return view('certificado.index', compact('capacitacion'));
    }

    public function bsestudiante(Request $request){
        $data=[];
        if($request->filled('q')){
            $data=Estudiante::select("nombre","id")
                ->where('nombre', 'LIKE', '%'.$request->get('q').'%')
                ->orderBy('nombre')
                ->get();
        }
        return response()->json($data);
    }

    public function store(Request $request, Capacitacion $capacitacion){
        $request->validate([
            'estudiante_id'=>'required',
            'emision'=>'required|date',
            'nota'=>'nullable|numeric'
        ],
        [
            'estudiante_id.required'=>'Elija un estudiante',
            'emision.required'=>'Ingrese fecha',
            'emision'=>'Fecha válida',
            'nota.numeric'=>'Ingrese número'
        ]
    );
        dd($request->all());
        $certificado = new Certificado();

    }
}
