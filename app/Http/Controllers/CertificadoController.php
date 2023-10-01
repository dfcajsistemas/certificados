<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Certificado;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function store(Request $request){

        $resultado="success";
        $mensaje="Certificado agregado.";

        $request->validate(
            [
                'estudiante_id'=>'required',
                'emision'=>'required|date',
                'nota'=>'nullable|numeric'
            ],
            [
                'estudiante_id.required'=>'Elija un estudiante',
                'emision.required'=>'Ingrese fecha',
                'emision.date'=>'Fecha válida',
                'nota.numeric'=>'Ingrese número'
            ]
        );

        if(Certificado::where('capacitacion_id', $request->cap)->where('estudiante_id', $request->estudiante_id)->first()){
            $resultado="error";
            $mensaje="El estudiante ya cuenta con certificado registrado.";
        }else{
            $certificado = new Certificado();
            $certificado->estado=null;
            $certificado->emision=$request->emision;
            $certificado->nota=$request->nota;
            $certificado->estudiante_id=$request->estudiante_id;
            $certificado->capacitacion_id=$request->cap;
            $certificado->created_by=Auth::user()->id;
            $certificado->updated_by=Auth::user()->id;

            $certificado->save();

            QrCode::generate(route('rcertificado', $certificado->id), '../public/qrcodes/'.$certificado->id.'.svg');
        }

        return back()->with($resultado,$mensaje);

    }
}
