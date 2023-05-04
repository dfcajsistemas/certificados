<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Livewire\Accesos;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Capacitaciones;
use App\Http\Livewire\Consultas;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Estudiantes;
use App\Http\Livewire\Inicio;
use App\Models\Certificado;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    //Route::get('/inicio', Inicio::class)->name('inicio');
    //Route::get('/admin', Admin::class)->name('admin');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/accesos', Accesos::class)->name('accesos');
    Route::get('/estudiantes', Estudiantes::class)->name('estudiantes');
    Route::get('/capacitaciones', Capacitaciones::class)->name('capacitaciones');
    Route::get('/capacitaciones/{capacitacion}', [CertificadoController::class, 'certificados'])->name('capacitaciones.certificados');
    Route::get('/capacitaciones/certificados/bsestudiante', [CertificadoController::class, 'bsestudiante'])->name('capacitaciones.certificados.bsestudiante');
    Route::post('/capacitaciones/certificados/store', [CertificadoController::class, 'store'])->name('capacitaciones.certificados.store');
    Route::get('/consultas', Consultas::class)->name('consultas');
});
