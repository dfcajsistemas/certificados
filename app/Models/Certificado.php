<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'emision',
        'nota',
        'estudiante_id',
        'capacitacion_id',
        'created_by',
        'updated_by'
    ];

    public function capacitacion(){
        return $this->belongsTo(Capacitacion::class);
    }

    public function estudiante(){
        return $this->belongsTo(Estudiante::class);
    }
}
