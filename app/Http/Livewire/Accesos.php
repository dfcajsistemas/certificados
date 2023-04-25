<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Accesos extends Component
{
    use WithPagination;

    public $buscar, $name, $email, $rol, $metodo, $mtitulo, $idm;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>10]
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
        $users=User::where('name', 'like', '%'.$this->buscar.'%')->paginate($this->porPagina);
        return view('livewire.accesos', compact('users'))
            ->layoutData(['page'=>'Accesos']);;
    }

    public function create(){
        $this->mtitulo='Nuevo usuario';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store(){
        //dd($this->rol);
        $rules=[
            'name'=>'required|min:3',
            'email'=>'required|unique:users,email|email',
        ];
        $messages=[
            'name.required'=>'Ingrese un nombre',
            'name.min'=>'Mínimo 3 caracteres',
            'email.required'=>'Ingrese un correo',
            'email.unique'=>'El correo ya existe',
            'email.email'=>'Ingrese un correo válido'

        ];
        $this->validate($rules, $messages);

        $password=Str::random(8);
        $user=User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'rol'=>($this->rol==1?1:null),
            'password'=>bcrypt($password)
        ]);

        $this->emit('add', "Usuario $user->name creado con contraseña <b>$password<b>");
    }

    public function resetCom(){
        $this->reset(['name', 'email', 'buscar', 'idm', 'porPagina']);
        $this->resetValidation();
    }
}
