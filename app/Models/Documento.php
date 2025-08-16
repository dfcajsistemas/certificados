<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable=['codigo', 'enlace', 'fecha', 'estado', 'disciplina_id', 'proyecto_id', 'empresa_id', 'created_by', 'updated_by'];

    //relaciones uno a muchos
    public function revisions(){
        return $this->hasMany(Revision::class);
    }

    //relacines uno a muchos inversa
    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }

    public function proyecto(){
        return $this->belongsTo(Proyecto::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
