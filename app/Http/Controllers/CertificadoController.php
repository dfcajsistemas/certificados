<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function certificados(Capacitacion $capacitacion){
        return view('certificado.index', compact('capacitacion'));
    }
}
