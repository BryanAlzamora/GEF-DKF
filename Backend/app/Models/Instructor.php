<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = "instructor";
    protected $primaryKey="ID_Usuario";
    protected $fillable = [
        'ID_Usuario',
        'CIF_Empresa'
    ];
    public function user(){
        return $this->belongsTo(User::class,"ID_Usuario","id");
    }
    public function instructor(){
        return $this->belongsTo(User::class,"ID_Usuario","ID");
    }
    public function tutores(){
        return $this->belongsToMany(Tutor::class,"tutor_instructor","ID_Instructor","ID_Tutor");
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,"CIF_Empresa","CIF");
    }
}
