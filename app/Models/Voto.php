<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    public function eleccione(){
        return $this->belongsTo(Eleccione::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lista(){
        return $this->belongsTo(Lista::class);
    }
}
