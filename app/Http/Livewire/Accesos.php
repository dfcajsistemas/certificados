<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Accesos extends Component
{
    use WithPagination;

    public $buscar, $name, $email, $rol, $metodo, $mtitulo, $nfotocheck, $idm;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>'10']
    ];

    protected $paginationTheme='bootstrap';
    protected $listeners=['estado', 'password'];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function updatingPorPagina(){
        $this->resetPage();
    }

    public function render()
    {
        $users=User::where('name', 'like', '%'.$this->buscar.'%')->orWhere('nfotocheck', 'like', '%'.$this->buscar.'%')->orderBy('name')->paginate($this->porPagina);
        return view('livewire.accesos', compact('users'))
            ->layoutData(['page'=>'Accesos']);
    }

    public function create(){
        $this->mtitulo='Nuevo usuario';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store(){
        $rules=[
            'name'=>'required|min:3',
            'nfotocheck'=>'required|unique:users,nfotocheck',
            'email'=>'required|unique:users,email|email',
        ];
        $messages=[
            'name.required'=>'Ingrese un nombre',
            'name.min'=>'Mínimo 3 caracteres',
            'nfotocheck.required'=>'Ingrese un número de fotocheck',
            'nfotocheck.unique'=>'El número de fotocheck ya existe',
            'email.required'=>'Ingrese un correo',
            'email.unique'=>'El correo ya existe',
            'email.email'=>'Ingrese un correo válido'

        ];
        $this->validate($rules, $messages);

        $password=Str::random(8);
        $user=User::create([
            'name'=>$this->name,
            'nfotocheck'=>$this->nfotocheck,
            'email'=>$this->email,
            'rol'=>($this->rol == 1 ? 1 : null),
            'password'=>bcrypt($password),
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id,
        ]);

        $this->emit('add', "Correo: <b>$user->email</b><br>Contraseña: <b>$password<b>");
    }

    public function edit(User $user){
        $this->mtitulo='Editar usuario';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$user->id;
        $this->name=$user->name;
        $this->nfotocheck=$user->nfotocheck;
        $this->email=$user->email;
        $this->rol=$user->rol;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'name'=>'required|min:3',
            'nfotocheck'=>"required|unique:users,nfotocheck, {$this->idm}",
            'email'=>"required|email|unique:users,email,{$this->idm}",
        ];
        $messages=[
            'name.required'=>'Ingrese un nombre',
            'name.min'=>'Mínimo 3 caracteres',
            'nfotocheck.required'=>'Ingrese un número de fotocheck',
            'nfotocheck.unique'=>'El número de fotocheck ya existe',
            'email.required'=>'Ingrese un correo',
            'email.unique'=>'El correo ya existe',
            'email.email'=>'Ingrese un correo válido'

        ];
        $this->validate($rules, $messages);

        $user=User::findOrFail($this->idm);

        $user->name=$this->name;
        $user->nfotocheck=$this->nfotocheck;
        $user->email=$this->email;
        $user->rol=$this->rol==1 ? 1 : null;
        $user->updated_by=Auth::user()->id;

        $user->save();

        $this->emit('edit', 'Se actualizó el usuario');
    }

    public function estado(User $user){
        $est='activó';
        if($user->estado){
            $user->estado=null;
            $est='desacivó';
        }else{
            $user->estado=1;
        }

        $user->updated_by=Auth::user()->id;
        $user->save();

        $this->emit('status', "Se <b>$est</b> al usuario");
    }

    public function password(User $user){

        $pas=Str::random(8);

        $user->password=bcrypt($pas);

        $user->updated_by=Auth::user()->id;
        $user->save();

        $this->emit('pass', "Correo: <b>$user->email</b><br>Contraseña: <b>$pas</b>");
    }

    public function resetCom(){
        $this->reset(['name', 'email', 'rol', 'buscar', 'idm', 'porPagina', 'nfotocheck']);
        $this->resetValidation();
    }
}
