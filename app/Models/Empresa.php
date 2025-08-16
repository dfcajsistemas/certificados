<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable=['razon_social', 'responsable', 'correo', 'telefono', 'estado', 'created_by', 'updated_by'];

    //relación uno a muchos
    public function documentos(){
        return $this->hasMany(Documento::class);
    }

    //relaciones muchos a muhos
    public function proyectos(){
        return $this->belongsToMany(Proyecto::class);
    }
}
