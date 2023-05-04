<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'horas',
        'desde',
        'hasta'
    ];

    public function certificados(){
        return $this->hasMany(Certificado::class);
    }

}
