<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'dni',
        'correo',
        'telefono'
    ];

    public function certificados(){
        return $this->hasMany(Certificado::class);
    }
}
