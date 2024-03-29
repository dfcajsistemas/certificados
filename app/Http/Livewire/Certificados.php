<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Certificados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $cap, $buscar, $nombre, $emision, $nota, $metodo, $mtitulo, $idm, $cer;
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
                        ->select('estudiantes.nombre', 'certificados.emision', 'certificados.nota', 'certificados.estado', 'certificados.id', 'certificados.file', 'certificados.estudiante_id', 'certificados.capacitacion_id')
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
        $men='Se activó el certificado';
        $te=true;
        if($certificado->estado){
            $certificado->estado=null;
            $men='Se desactivó el certificado';
        }else{
            if($certificado->file){
                $certificado->estado=1;
            }else{
                $men="Agregue el certificado para activar";
            }
        }

        if($te){
            $certificado->updated_by=Auth::user()->id;
            $certificado->save();

            $this->emit('status_s', $men);
        }else{
            $this->emit('status_e', $men);
        }
    }

    public function destroy(Certificado $certificado){


        $certificado->delete();

        $this->emit('delete', "Se eliminó el certificado");
    }

    public function vcer(Certificado $certificado){
        $this->mtitulo='Certificado';
        $this->metodo='gcer';

        $this->resetCom();

        $this->idm=$certificado->id;
        $this->nombre=$certificado->estudiante->nombre;

        $this->emit('smc', 'Mostrar modal');

    }

    public function gcer(){
        $rules=[
            'cer'=>'required|mimes:pdf|max:2048',
        ];
        $messages=[
            'cer.required'=>'Elija un certificado',
            'cer.mimes'=>'Solo se acepta archivos pdf',
            'cer.max'=>'Solo imagenes de hasta 2Mb'
        ];
        $this->validate($rules, $messages);

        $certi=Certificado::findOrFail($this->idm);

        $nom_file=$certi->capacitacion_id.$certi->estudiante_id.'.'.$this->cer->extension();

        $this->cer->storeAs('public/certificados', $nom_file);


        $certi->file=$nom_file;
        $certi->estado=1;
        $certi->save();

        $this->emit('cer', "Se guardo el certificado");
    }

    public function resetCom(){
        $this->reset(['emision', 'nota', 'buscar', 'idm', 'porPagina', 'cer']);
        $this->resetValidation();
    }
}
