<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{

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

    public function restudiante(Request $request){

            $certificados=Certificado::where('estudiante_id',$request->estudiante_id)->paginate(10);

        return view('consultas.restudiante', compact('certificados'));
    }
}
