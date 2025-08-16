<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    protected $fillable=['f_asignacion', 'f_revision', 'observaciones', 'estado_doc', 'estado', 't_revision', 'documento_id', 'user_id', 'created_by', 'updated_by'];

    //Relaciones uno a muchos inversa
    public function documento(){
        return $this->belongsTo(Documento::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
