<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificado;
use App\Models\Estudiante;

class FrontController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function certificado(Request $request)
    {
        if(isset($request->codigo)){
            if(str_contains($request->codigo,'-')){
                $capacitacion_id=explode('-',$request->codigo)[0];
                $estudiante_id=explode('-',$request->codigo)[1];
                if(is_numeric($capacitacion_id) && is_numeric($estudiante_id)){
                    $certificado = Certificado::where('capacitacion_id', $capacitacion_id)->where('estudiante_id', $estudiante_id)->first();
                    if ($certificado) {
                        return redirect()->route('rcertificado', $certificado);
                    } else {
                        return back()->with('error', 'No se encontró el certificado');
                    }
                }else{
                    return back()->with('error', 'El código no es válido');
                }
            }else{
                return back()->with('error', 'El código no es válido');
            }
        }else{
            return view('certificado');
        }

    }

    public function documento(Request $request){
        if(isset($request->documento)){
            $estudiante=Estudiante::where('dni',$request->documento)->first();
            if($estudiante){
                return redirect()->route('restudiante', $estudiante);
            }else{
                return back()->with('error', 'No se encontró certificados para el DNI ingresado');
            }
        }else{
            return view('documento');
        }
    }

    public function restudiante(Estudiante $estudiante){
        $certificados=Certificado::where('estudiante_id',$estudiante->id)->where('estado',1)->paginate(10);
        return view('restudiante', compact('certificados', 'estudiante'));
    }

    public function rcertificado(Certificado $certificado){
        return view('rcertificado', compact('certificado'));
    }
}
