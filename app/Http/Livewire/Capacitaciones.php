<?php

namespace App\Http\Livewire;

use App\Models\Capacitacion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Capacitaciones extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $nombre, $tipo, $horas, $desde, $hasta;
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
        $capacitacions=Capacitacion::where('nombre', 'like', '%'.$this->buscar.'%')
                    ->orderBy('nombre')
                    ->paginate($this->porPagina);
        return view('livewire.capacitaciones', compact('capacitacions'))
            ->layoutData(['page'=>'Capacitaciones']);
    }

    public function create(){

        $this->mtitulo='Nueva capacitación';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal!');
    }

    public function store(){
        $rules=[
            'nombre'=>'required|min:6',
            'tipo'=>'required',
            'horas'=>'nullable|numeric',
            'desde'=>'required|date',
            'hasta'=>'nullable|date',
        ];

        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 6 caracteres',
            'tipo.required'=>'Ingrese el tipo',
            'horas.numeric'=>'Ingrese un número',
            'desde.required'=>'Ingrese inicio',
            'desde.date'=>'Ingrese una fecha',
            'hasta.date'=>'Ingrese una fecha'
        ];

        $this->validate($rules, $messages);

        $capacitacion=Capacitacion::create([
            'nombre'=>$this->nombre,
            'tipo'=>$this->tipo,
            'horas'=>$this->horas,
            'desde'=>$this->desde,
            'hasta'=>$this->hasta,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('add', "Capacitacion <b>$capacitacion->nombre</b> creada");
    }

    public function edit(Capacitacion $capacitacion){
        $this->mtitulo='Editar capacitacion';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$capacitacion->id;
        $this->nombre=$capacitacion->nombre;
        $this->tipo=$capacitacion->tipo;
        $this->horas=$capacitacion->horas;
        $this->desde=$capacitacion->desde;
        $this->hasta=$capacitacion->hasta;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'nombre'=>'required|min:6',
            'tipo'=>'required',
            'horas'=>'nullable|numeric',
            'desde'=>'required|date',
            'hasta'=>'nullable|date',
        ];

        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 6 caracteres',
            'tipo.required'=>'Ingrese el tipo',
            'horas.numeric'=>'Ingrese un número',
            'desde.required'=>'Ingrese inicio',
            'desde.date'=>'Ingrese una fecha',
            'hasta.date'=>'Ingrese una fecha'
        ];
        $this->validate($rules, $messages);

        $capacitacion=Capacitacion::findOrFail($this->idm);

        $capacitacion->nombre=$this->nombre;
        $capacitacion->tipo=$this->tipo;
        $capacitacion->horas=$this->horas;
        $capacitacion->desde=$this->desde;
        $capacitacion->hasta=$this->hasta;
        $capacitacion->updated_by=Auth::user()->id;

        $capacitacion->save();

        $this->emit('edit', 'Se actualizó al capacitacion');
    }

    public function estado(Capacitacion $capacitacion){
        $est='activó';
        if($capacitacion->estado){
            $capacitacion->estado=null;
            $est='desacivó';
        }else{
            $capacitacion->estado=1;
        }

        $capacitacion->updated_by=Auth::user()->id;
        $capacitacion->save();

        $this->emit('status', "Se <b>$est</b> la capacitación");
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm', 'nombre', 'tipo', 'horas', 'desde', 'hasta']);
        $this->resetValidation();
    }
}
