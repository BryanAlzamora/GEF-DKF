<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $table="competencia";
    protected $fillable=[
        "descripcion",
        "ID_Grado"
    ];

    public function compRa(){
        return $this->hasOne(compRa::class,"comp_ra","ID_Comp");
    }
    public function notasCompentencias(){
        return $this->hasMany(NotaCompetencia::class,"ID_Compentencia");
    }
    public function grado(){
        return $this-> belongsTo(Grado::class, "ID_Grado");
    }

}
