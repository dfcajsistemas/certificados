<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Empresas extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $razon_social, $responsable, $correo, $telefono;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>'10']
    ];

    protected $paginationTheme='bootstrap';
    protected $listeners=['destroy'];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function updatingPorPagina(){
        $this->resetPage();
    }

    public function render()
    {
        $empresas=Empresa::where('razon_social', 'like', '%'.$this->buscar.'%')
                    ->orderBy('razon_social')
                    ->paginate($this->porPagina);
        return view('livewire.empresas', compact('empresas'))
            ->layoutData(['page'=>'Empresas']);
    }

    public function create(){
        $this->mtitulo='Nueva empresa';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store(){
        $rules=[
            'razon_social'=>'required|min:3|unique:empresas,razon_social',
            'responsable'=>'required|min:3',
            'correo'=>'required|email',
            'telefono'=>'required|min:6',
        ];
        $messages=[
            'razon_social.required'=>'Ingrese una razón social',
            'razon_social.min'=>'Mínimo 3 caracteres',
            'razon_social.unique'=>'La razón social ya existe',
            'responsable.required'=>'Ingrese un responsable',
            'responsable.min'=>'Mínimo 3 caracteres',
            'correo.required'=>'Ingrese un correo',
            'correo.email'=>'Ingrese un correo válido',
            'telefono.required'=>'Ingrese un teléfono',
            'telefono.min'=>'Mínimo 6 caracteres'
        ];

        $this->validate($rules, $messages);

        Empresa::create([
            'razon_social'=>mb_strtoupper($this->razon_social),
            'responsable'=>$this->responsable,
            'correo'=>$this->correo,
            'telefono'=>$this->telefono,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Empresa agregada');
    }

    public function edit(Empresa $empresa){
        $this->mtitulo='Editar empresa';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$empresa->id;
        $this->razon_social=$empresa->razon_social;
        $this->responsable=$empresa->responsable;
        $this->correo=$empresa->correo;
        $this->telefono=$empresa->telefono;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'razon_social'=>'required|min:3|unique:empresas,razon_social,'.$this->idm,
            'responsable'=>'required|min:3',
            'correo'=>'required|email',
            'telefono'=>'required|min:6',
        ];
        $messages=[
            'razon_social.required'=>'Ingrese una razón social',
            'razon_social.min'=>'Mínimo 3 caracteres',
            'razon_social.unique'=>'La razón social ya existe',
            'responsable.required'=>'Ingrese un responsable',
            'responsable.min'=>'Mínimo 3 caracteres',
            'correo.required'=>'Ingrese un correo',
            'correo.email'=>'Ingrese un correo válido',
            'telefono.required'=>'Ingrese un teléfono',
            'telefono.min'=>'Mínimo 6 caracteres'
        ];

        $this->validate($rules, $messages);

        $empresa=Empresa::find($this->idm);

        $empresa->update([
            'razon_social'=>mb_strtoupper($this->razon_social),
            'responsable'=>$this->responsable,
            'correo'=>$this->correo,
            'telefono'=>$this->telefono,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Empresa actualizada');
    }

    public function estado(Empresa $empresa){
        if($empresa->estado==1){
            $empresa->update([
                'estado'=>NULL,
                'updated_by'=>Auth::user()->id
            ]);
        }else{
            $empresa->update([
                'estado'=>1,
                'updated_by'=>Auth::user()->id
            ]);
        }

        $this->emit('ms', 'Estado actualizado');
    }

    public function destroy(Empresa $empresa){
        if($empresa->documentos->count() || $empresa->proyectos->count()){
            $this->emit('me', 'El empresa no se puede eliminar porque tiene registros asociados');
            return;
        }else{
            $empresa->delete();
            $this->emit('ms', 'empresa eliminada');
        }
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm','razon_social', 'responsable', 'correo', 'telefono']);
        $this->resetValidation();
    }
}
