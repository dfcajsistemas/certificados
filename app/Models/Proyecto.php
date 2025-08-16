<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable=['nombre', 'estado', 'created_by', 'updated_by'];

    //relación uno a muchos
    public function documentos(){
        return $this->hasMany(Documento::class);
    }

    //relaciones muchos a muhos
    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }
}
