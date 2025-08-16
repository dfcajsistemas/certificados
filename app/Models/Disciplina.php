<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable=['nombre', 'estado', 'created_by', 'updated_by'];

    //relación uno a muchos
    public function documentos(){
        return $this->hasMany(Documento::class);
    }

    //relaciones muchos a muhos
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
