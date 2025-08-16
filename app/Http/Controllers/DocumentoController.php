<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function create()
    {
        $disciplinas=Disciplina::where('estado', '1')->orderBy('nombre')->get();
        $proyectos=Proyecto::where('estado', '1')->orderBy('nombre')->get();
        $empresas=Empresa::where('estado', '1')->orderBy('razon_social')->get();
        return view('documento.create', compact('disciplinas', 'proyectos', 'empresas'));
    }

    public function bempresas(Proyecto $proyecto)
    {
        $empresas=$proyecto->empresas()->where('estado', '1')->select('empresas.id', 'empresas.razon_social')->orderBy('razon_social')->get();
        return $empresas;
    }

}
