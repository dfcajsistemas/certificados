<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleccione extends Model
{
    use HasFactory;

    public function votos(){
        return $this->hasMany(Voto::class);
    }

    public function listas(){
        return $this->hasMany(Lista::class);
    }
}
