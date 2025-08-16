<?php

use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Livewire\Accesos;
use App\Http\Livewire\Consultas;
use App\Http\Livewire\Contrasena;
use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Disciplinas;
use App\Http\Livewire\Documentos;
use App\Http\Livewire\Empresas;
use App\Http\Livewire\Proyectos;
use App\Http\Livewire\Revisiones;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view("welcome");
});

Route::get('storage-link', function(){
    $targetFolder=storage_path('app/public');
    $linkFolder=$_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder,$linkFolder);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    route::get('/contrasena', Contrasena::class)->name('contrasena');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/accesos', Accesos::class)->name('accesos')->middleware('admin');
    Route::get('/disciplinas', Disciplinas::class)->name('disciplinas')->middleware('admin');
    Route::get('/disciplinas/busers', [DisciplinaController::class, 'busers'])->name('disciplinas.busers')->middleware('admin');
    Route::get('/disciplinas/{disciplina}', [DisciplinaController::class, 'index'])->name('disciplinas.users')->middleware('admin');
    Route::post('/disciplinas/{disciplina}/users', [DisciplinaController::class, 'store'])->name('disciplinas.users.store')->middleware('admin');
    Route::get('/proyectos', Proyectos::class)->name('proyectos')->middleware('admin');
    Route::get('/proyectos/bempresa', [ProyectoController::class, 'bempresas'])->name('proyectos.bempresas')->middleware('admin');
    Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'index'])->name('proyectos.empresas')->middleware('admin');
    Route::post('/proyectos/{proyecto}/empresas', [ProyectoController::class, 'store'])->name('proyectos.empresas.store')->middleware('admin');
    Route::get('/empresas', Empresas::class)->name('empresas')->middleware('admin');
    Route::get('/documentos', Documentos::class)->name('documentos')->middleware('admin');
    Route::resource('/documentos', DocumentoController::class)->except(['index', 'show', 'destroy'])->names('documentos')->middleware('admin');
    Route::get('/documentos/bempresas/{proyecto}', [DocumentoController::class, 'bempresas'])->name('documentos.bempresas')->middleware('admin');
    
    Route::get('/revisiones', Revisiones::class)->name('revisiones');
    Route::get('/consultas', Consultas::class)->name('consultas');
});
