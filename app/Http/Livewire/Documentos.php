<?php

namespace App\Http\Livewire;

use App\Models\Disciplina;
use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Revision;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Documentos extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $codigo, $enlace, $fecha, $empresa_id, $user_id;
    public $proyecto_id = null;
    public $disciplina_id = null;
    public $empresas = null;
    public $users = null;
    public $porPagina = '10';

    protected $queryString = [
        'buscar' => ['except' => ''],
        'porPagina' => ['except' => '10']
    ];

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['destroy'];

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingPorPagina()
    {
        $this->resetPage();
    }

    public function render()
    {
        $documentos = Documento::where('codigo', 'like', '%' . $this->buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->porPagina);
        $proyectos = Proyecto::where('estado', 1)->select('id', 'nombre')->orderBy('nombre')->get();
        $disciplinas = Disciplina::where('estado', 1)->select('id', 'nombre')->orderBy('nombre')->get();
        return view('livewire.documentos', compact('documentos', 'proyectos', 'disciplinas'))
            ->layoutData(['page' => 'Documentos']);
    }

    public function updatedProyectoId($proyecto_id)
    {
        if ($proyecto_id) {
            $this->reset(['empresa_id']);
            $this->empresas = Proyecto::findOrFail($proyecto_id)->empresas()->where('empresas.estado', 1)->select('empresas.id', 'empresas.razon_social')->orderBy('razon_social')->get();
        } else {
            $this->reset(['empresa_id', 'empresas']);
        }
    }

    public function updatedDisciplinaId($disciplina_id)
    {
        if ($disciplina_id) {
            $this->reset(['user_id']);
            $this->users = Disciplina::findOrFail($disciplina_id)->users()->where('users.estado', 1)->select('users.id', 'users.name')->orderBy('name')->get();
        } else {
            $this->reset(['user_id', 'users']);
        }
    }

    public function create()
    {
        $this->mtitulo = 'Nuevo documento';
        $this->metodo = 'store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store()
    {
        $this->validate(
            [
                'codigo' => 'required',
                'enlace' => 'required',
                'fecha' => 'required|date',
                'proyecto_id' => 'required',
                'disciplina_id' => 'required',
                'empresa_id' => 'required',
                'user_id' => 'required'
            ],
            [
                'codigo.required' => 'Ingrese un código',
                'enlace.required' => 'Ingrese el enlace',
                'fecha.required' => 'Ingrese una fecha',
                'fecha.date' => 'Ingrese una fecha válida',
                'proyecto_id.required' => 'Seleccione un proyecto',
                'disciplina_id.required' => 'Seleccione una disciplina',
                'empresa_id.required' => 'Seleccione una empresa',
                'user_id.required' => 'Seleccione un responsable'
            ]
        );

        try {
            DB::beginTransaction();
            $documento = Documento::create([
                'codigo' => $this->codigo,
                'enlace' => $this->enlace,
                'fecha' => $this->fecha,
                'disciplina_id' => $this->disciplina_id,
                'proyecto_id' => $this->proyecto_id,
                'empresa_id' => $this->empresa_id,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            Revision::create([
                'f_asignacion' => $this->fecha,
                'documento_id' => $documento->id,
                'user_id' => $this->user_id,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            DB::commit();
            $this->emit('ms', 'Documento registrado');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('me', 'Error al registrar el documento ' . $e->getMessage());
        }
    }

    public function edit(Documento $documento)
    {
        $this->mtitulo = 'Editar documento';
        $this->metodo = 'update';

        $this->resetCom();

        //dd($documento->revisions->whereNull('estado_doc')->first()->user_id);

        $this->idm = $documento->id;
        $this->codigo = $documento->codigo;
        $this->enlace = $documento->enlace;
        $this->fecha = $documento->fecha;
        $this->proyecto_id = $documento->proyecto_id;
        $this->disciplina_id = $documento->disciplina_id;
        $this->empresa_id = $documento->empresa_id;
        $this->user_id = $documento->revisions->whereNull('estado_doc')->first()->user_id;

        $this->emit('sm', 'Mostrar modal');
    }

    public function resetCom()
    {
        $this->reset(['buscar', 'porPagina', 'idm', 'codigo', 'enlace', 'fecha', 'proyecto_id', 'disciplina_id', 'empresa_id', 'user_id']);
        $this->resetValidation();
    }
}
