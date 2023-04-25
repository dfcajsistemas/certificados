<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    public function votos(){
        return $this->hasMany(Lista::class);
    }

    public function eleccione(){
        return $this->belongsTo(Eleccione::class);
    }
}
