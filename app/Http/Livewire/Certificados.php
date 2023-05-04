<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Certificados extends Component
{
    use WithPagination;

    public $cap, $buscar, $nombre, $emision, $nota, $metodo, $mtitulo, $idm;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>'10']
    ];

    protected $paginationTheme='bootstrap';
    protected $listeners=['estado', 'destroy'];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function updatingPorPagina(){
        $this->resetPage();
    }

    public function render()
    {
        $certificados=DB::table('certificados')
                        ->join('estudiantes', 'certificados.estudiante_id', '=', 'estudiantes.id')
                        ->select('estudiantes.nombre', 'certificados.emision', 'certificados.nota', 'certificados.estado', 'certificados.id')
                        ->where('certificados.capacitacion_id', $this->cap)
                        ->where('estudiantes.nombre', 'like', '%'.$this->buscar.'%')
                        ->orderBy('estudiantes.nombre')
                        ->paginate($this->porPagina);
        return view('livewire.certificados', compact('certificados'));
    }

    public function edit(Certificado $certificado){
        $this->mtitulo='Editar certificado';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$certificado->id;
        $this->nombre=$certificado->estudiante->nombre;
        $this->emision=$certificado->emision;
        $this->nota=$certificado->nota;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'emision'=>'required|date',
            'nota'=>'nullable|numeric'
        ];
        $messages=[
            'emision.required'=>'Ingrese fecha',
            'emision.date'=>'Fecha válida',
            'nota.numeric'=>'Ingrese número'
        ];
        $this->validate($rules, $messages);

        $certificado=Certificado::findOrFail($this->idm);

        $certificado->emision=$this->emision;
        $certificado->nota=$this->nota;
        $certificado->updated_by=Auth::user()->id;

        $certificado->save();

        $this->emit('edit', 'Datos del certificado actualizados');
    }

    public function estado(Certificado $certificado){
        $est='activó';
        if($certificado->estado){
            $certificado->estado=null;
            $est='desactivó';
        }else{
            $certificado->estado=1;
        }

        $certificado->updated_by=Auth::user()->id;
        $certificado->save();

        $this->emit('status', "Se <b>$est</b> al usuario");
    }

    public function destroy(Certificado $certificado){
        $certificado->delete();

        $this->emit('delete', "Se eliminó el certificado");
    }

    public function resetCom(){
        $this->reset(['emision', 'nota', 'buscar', 'idm', 'porPagina']);
        $this->resetValidation();
    }
}
