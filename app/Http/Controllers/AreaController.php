<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function area(Request $request){
        $sede_id=$request->isede;
        return view('area', compact('sede_id'));
    }

    public function bsedes(Request $request){
        $data=[];
        if($request->filled('q')){
            $data=Sede::select('id', 'nombre')
                ->where('nombre', 'like', '%'.$request->get('q').'%')
                ->orderBy('nombre')
                ->get();
        }
        return response()->json($data);
    }
}
