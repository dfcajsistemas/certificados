<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Estudiantes extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $nombre, $dni, $correo, $telefono;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>'10']
    ];

    protected $paginationTheme='bootstrap';
    protected $listeners=['estado'];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function updatingPorPagina(){
        $this->resetPage();
    }

    public function render()
    {
        $estudiantes=Estudiante::where('nombre', 'like', '%'.$this->buscar.'%')
                    ->orWhere('dni', 'like', '%'.$this->buscar.'%')
                    ->orderBy('nombre')
                    ->paginate($this->porPagina);
        return view('livewire.estudiantes', compact('estudiantes'))
            ->layoutData(['page'=>'Estudiantes']);
    }

    public function create(){

        $this->mtitulo='Nuevo estudiante';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal!');
    }

    public function store(){
        $rules=[
            'nombre'=>'required|min:3',
            'dni'=>'required|min:8|unique:estudiantes,dni',
            'correo'=>'nullable|email'
        ];

        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 3 caracteres',
            'dni.required'=>'Ingrese # documento',
            'dni.min'=>'Mínimo 8 caracteres',
            'dni.unique'=>'# documento existe',
            'correo.email'=>'Correo no válido'
        ];

        $this->validate($rules, $messages);

        $estudiante=Estudiante::create([
            'nombre'=>strtoupper($this->nombre),
            'dni'=>$this->dni,
            'telefono'=>$this->telefono,
            'correo'=>$this->correo,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('add', "Estudiante <b>$estudiante->nombre</b> creado.");
    }

    public function edit(Estudiante $estudiante){
        $this->mtitulo='Editar estudiante';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$estudiante->id;
        $this->nombre=$estudiante->nombre;
        $this->dni=$estudiante->dni;
        $this->telefono=$estudiante->telefono;
        $this->correo=$estudiante->correo;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'nombre'=>'required|min:3',
            'dni'=>"required|min:8|unique:estudiantes,dni,{$this->idm}",
            'correo'=>'nullable|email'
        ];

        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 3 caracteres',
            'dni.required'=>'Ingrese # documento',
            'dni.min'=>'Mínimo 8 caracteres',
            'dni.unique'=>'# documento existe',
            'correo.email'=>'Correo no válido'
        ];
        $this->validate($rules, $messages);

        $estudiante=Estudiante::findOrFail($this->idm);

        $estudiante->nombre=strtoupper($this->nombre);
        $estudiante->dni=$this->dni;
        $estudiante->telefono=$this->telefono;
        $estudiante->correo=$this->correo;
        $estudiante->updated_by=Auth::user()->id;

        $estudiante->save();

        $this->emit('edit', 'Se actualizó al estudiante');
    }

    public function estado(Estudiante $estudiante){
        $est='activó';
        if($estudiante->estado){
            $estudiante->estado=null;
            $est='desacivó';
        }else{
            $estudiante->estado=1;
        }

        $estudiante->updated_by=Auth::user()->id;
        $estudiante->save();

        $this->emit('status', "Se <b>$est</b> al estudiante");
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm', 'nombre', 'dni', 'correo', 'telefono']);
        $this->resetValidation();
    }
}
