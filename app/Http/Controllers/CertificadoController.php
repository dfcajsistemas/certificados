<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
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
        dd($capacitacion);
    }
}
